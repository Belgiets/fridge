<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\AdminUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 * @Security("has_role('ROLE_SUPERADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="users_index")
     * @Method("GET")
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'users' => $this->getDoctrine()->getManager()->getRepository('AppBundle:User\AdminUser')->findAll()
        ];
    }

    /**
     * @Route("/new", name="user_new")
     * @Template("AppBundle:User:form.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $adminUser = new User\AdminUser();
        $adminUser->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(AdminUserType::class, $adminUser);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($adminUser);
            $em->flush();

            return $this->redirectToRoute('users_index');
        }

        return ['form' => $form->createView()];
    }
}
