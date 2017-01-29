<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Shelf;
use AppBundle\Form\ShelfType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/shelves")
 * @Security("has_role('ROLE_SUPERADMIN')")
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
     * @Route("/new", name="shelf_new")
     * @Template("AppBundle::defaultForm.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $shelf = new Shelf();

        $user = $this->getUser();

        $shelf->setCreatedBy($user);
        $shelf->setUpdatedBy($user);
        $shelf->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(ShelfType::class, $shelf, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($shelf);
            $em->flush();

            return $this->redirectToRoute('shelves_index');
        }

        return [
            'form' => $form->createView(),
            'formHeader' => 'Shelf create/edit',
            'formClass' => 'shelf-form'
        ];
    }

    /**
     * @Route("/{id}/edit", name="shelf_edit", requirements={"id": "\d+"})
     * @Template("AppBundle::defaultForm.html.twig")
     *
     * @param Request $request
     * @param Shelf $shelf
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Shelf $shelf)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ShelfType::class, $shelf, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $shelf->setUpdatedAt(new \DateTime());
            $shelf->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('shelves_index');
        }

        return [
            'form' => $form->createView(),
            'formHeader' => 'Shelf create/edit',
            'formClass' => 'shelf-form'
        ];
    }

    /**
     * @Route("/{id}/delete", name="shelf_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     * @Template("AppBundle::delete.html.twig")
     *
     * @param Request $request
     * @param Shelf $shelf
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Shelf $shelf)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('shelf_delete', ['id' => $shelf->getId()]))
            ->setMethod('DELETE')
            ->getForm();

        if ($request->getMethod() == Request::METHOD_GET) {
            return [
                'form' => $form->createView(),
                'id' => $shelf->getId()
            ];
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shelf);
            $em->flush();

            $this->addFlash('success', 'Shelf was deleted');
        } else {
            $this->addFlash('danger', 'Shelf didn\'t deleted');
        }

        return $this->redirectToRoute('shelves_index');
    }
}
