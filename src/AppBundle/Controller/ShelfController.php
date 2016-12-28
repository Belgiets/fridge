<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Shelf;
use AppBundle\Form\ShelfType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/shelves")
 */
class ShelfController extends Controller
{
    /**
     * @Route("/", name="shelves_index")
     * @Method("GET")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'shelves' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Shelf')->findAll()
        ];
    }

    /**
     * @Route("/new", name="shelf_new")`
     * @Template("AppBundle:Shelf:form.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Shelf();

        $user = $this->getUser();

        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $category->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(ShelfType::class, $category, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('shelves_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/edit/{id}", name="shelf_edit", requirements={"id": "\d+"})
     *
     * @Template("AppBundle:Shelf:form.html.twig")
     *
     * @param Request $request
     * @param Shelf $shelf
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Shelf $shelf)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(Shelf::class, $shelf, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $shelf->setUpdatedAt(new \DateTime());
            $shelf->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('shelves_index');
        }

        return ['form' => $form->createView()];
    }
}
