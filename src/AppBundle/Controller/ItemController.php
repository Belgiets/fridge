<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/items")
 * @Security("has_role('ROLE_ADMIN')")
 */
class ItemController extends Controller
{
    /**
     * @Route("/", name="items_index")
     * @Method("GET")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'items' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Item')->findAll()
        ];
    }

    /**
     * @Route("/new", name="item_new")`
     * @Template("AppBundle:Item:form.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = new Item();

        $user = $this->getUser();

        $item->setCreatedBy($user);
        $item->setUpdatedBy($user);
        $item->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(ItemType::class, $item, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('items_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/edit/{id}", name="item_edit", requirements={"id": "\d+"})
     *
     * @Template("AppBundle:Item:form.html.twig")
     *
     * @param Request $request
     * @param Item $item
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Item $item)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(Item::class, $item, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $item->setUpdatedAt(new \DateTime());
            $item->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('items_index');
        }

        return ['form' => $form->createView()];
    }
}
