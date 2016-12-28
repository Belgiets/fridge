<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

/**
 * @Route("/categories")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="categories_index")
     * @Method("GET")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'categories' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll()
        ];
    }

    /**
     * @Route("/new", name="category_new")`
     * @Template("AppBundle:Category:form.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();

        $user = $this->getUser();

        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $category->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(CategoryType::class, $category, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/edit/{id}", name="category_edit", requirements={"id": "\d+"})
     *
     * @Template("AppBundle:Category:form.html.twig")
     *
     * @param Request $request
     * @param Category $category
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Category $category)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(Category::class, $category, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $category->setUpdatedAt(new \DateTime());
            $category->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('categories_index');
        }

        return ['form' => $form->createView()];
    }
}
