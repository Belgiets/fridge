<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use AppBundle\Form\CategoryType;
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
        $user = $this->getUser();

        $category = new Category();
        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $category->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $formCategory = $this->createForm(CategoryType::class, $category, [
            'user' => $user,
            'action' => $this->generateUrl('category_new'),
        ]);

        $item = new Item();
        $item->setCreatedBy($user);
        $item->setUpdatedBy($user);
        $item->setUpdatedAt(new \DateTime());

        /** @var Form $formItem */
        $formItem = $this->createForm(ItemType::class, $item, ['user' => $user]);
        $formItem->handleRequest($request);

        if ($formItem->isValid()) {
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('items_index');
        }

        return [
            'formCategory' => $formCategory->createView(),
            'formItem' => $formItem->createView()
        ];
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

        $form = $this->createForm(ItemType::class, $item, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $item->setUpdatedAt(new \DateTime());
            $item->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('items_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/delete", name="item_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     * @Template("AppBundle::delete.html.twig")
     *
     * @param Request $request
     * @param Item $item
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Item $item)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', ['id' => $item->getId()]))
            ->setMethod('DELETE')
            ->getForm();

        if ($request->getMethod() == Request::METHOD_GET) {
            return [
                'form' => $form->createView(),
                'id' => $item->getId()
            ];
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();

            $this->addFlash('success', 'Item was deleted');
        } else {
            $this->addFlash('danger', 'Item didn\'t deleted');
        }

        return $this->redirectToRoute('items_index');
    }
}
