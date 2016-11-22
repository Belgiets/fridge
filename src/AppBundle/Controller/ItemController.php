<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ItemController extends Controller
{
    /**
     * @Route("/api/all-items", name="api_all_items")
     */
    public function allItemsAction() {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Item');

        $items = $repository->findAll();

        return new JsonResponse($items);
    }
}
