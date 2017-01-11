<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User\BaseUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if (($user) && ($user->getRole() === BaseUser::ROLE_ADMIN || $user->getRole() === BaseUser::ROLE_SUPERADMIN)) {
            return [];
        }

        return $this->redirectToRoute('login');
    }
}
