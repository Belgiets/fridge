<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class FoodController extends Controller
{
    /**
     * @Route("/api/all-foods", name="api_all_foods")
     */
    public function allCategoriesAction() {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Category ');

        $items = $repository->findAll();

        return new JsonResponse($items);
    }
}
