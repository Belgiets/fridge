<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Food;
use AppBundle\Form\FoodType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/foods")
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
        $category = new Food();

        $user = $this->getUser();

        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $category->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(FoodType::class, $category, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
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

        $form = $this->createForm(Food::class, $food, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $food->setUpdatedAt(new \DateTime());
            $food->setUpdatedBy($user);

            $em->flush();

            return $this->redirectToRoute('foods_index');
        }

        return ['form' => $form->createView()];
    }
}
