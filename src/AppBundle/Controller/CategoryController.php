<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

/**
 * @Route("/categories")
 * @Security("has_role('ROLE_ADMIN')")
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
     * @return array|JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
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

            if ($request->isXmlHttpRequest()) {
                $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();

                $categories = array_map(function($value){
                    return $value->jsonSerialize();
                }, $categories);

                return new JsonResponse([
                    'status' => 'ok',
                    'data' => $categories
                ]);
            }

            return $this->redirectToRoute('categories_index');
        } else {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'status' => 'error',
                    'data' => $form->getErrors(true)->__toString()
                ]);
            }
        }

        return [
            'form' => $form->createView()
        ];
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

    /**
     * @Route("/{id}/delete", name="category_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     * @Template("AppBundle::delete.html.twig")
     *
     * @param Request $request
     * @param Category $category
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', ['id' => $category->getId()]))
            ->setMethod('DELETE')
            ->getForm();

        if ($request->getMethod() == Request::METHOD_GET) {
            return [
                'form' => $form->createView(),
                'id' => $category->getId()
            ];
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            $this->addFlash('success', 'Category was deleted');
        } else {
            $this->addFlash('danger', 'Category didn\'t deleted');
        }

        return $this->redirectToRoute('categories_index');
    }
}
