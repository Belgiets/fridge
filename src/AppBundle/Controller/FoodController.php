<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Food;
use AppBundle\Form\FoodType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/foods")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FoodController extends Controller
{
    /**
     * @Route("/", name="foods_index")
     * @Method("GET")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'foods' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Food')->findAll()
        ];
    }

    /**
     * @Route("/new", name="food_new")`
     * @Template("AppBundle:Food:form.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $food = new Food();

        $user = $this->getUser();

        $food->setCreatedBy($user);
        $food->setUpdatedBy($user);
        $food->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(FoodType::class, $food, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($food);
            $em->flush();

            return $this->redirectToRoute('foods_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/edit/{id}", name="food_edit", requirements={"id": "\d+"})
     *
     * @Template("AppBundle:Food:form.html.twig")
     *
     * @param Request $request
     * @param Food $food
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, Food $food)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(FoodType::class, $food, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $food->setUpdatedAt(new \DateTime());
            $food->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('foods_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}/delete", name="food_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     * @Template("AppBundle::delete.html.twig")
     *
     * @param Request $request
     * @param Food $food
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Food $food)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('food_delete', ['id' => $food->getId()]))
            ->setMethod('DELETE')
            ->getForm();

        if ($request->getMethod() == Request::METHOD_GET) {
            return [
                'form' => $form->createView(),
                'id' => $food->getId()
            ];
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($food);
            $em->flush();

            $this->addFlash('success', 'Food was deleted');
        } else {
            $this->addFlash('danger', 'Food didn\'t deleted');
        }

        return $this->redirectToRoute('foods_index');
    }
}
