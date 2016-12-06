<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShelfController extends Controller
{
    /**
     * @Route("/shelfs", name="shelfs")
     */
    public function allShelfsAction() {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Shelf');

        $items = $repository->findAll();

        return new JsonResponse($items, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
