<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User\AdminUser;
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
     * @Template("AppBundle::defaultForm.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $adminUser = new AdminUser();
        $adminUser->setUpdatedAt(new \DateTime());

        /** @var Form $form */
        $form = $this->createForm(AdminUserType::class, $adminUser, [
            'password_encoder' => $this->get('security.password_encoder')
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($adminUser);
            $em->flush();

            return $this->redirectToRoute('users_index');
        }

        return [
            'form' => $form->createView(),
            'formHeader' => 'User create/edit',
            'formClass' => 'user-form'
        ];
    }

    /**
     * @Route("/{id}/edit", name="user_edit", requirements={"id": "\d+"})
     * @Template("AppBundle::defaultForm.html.twig")
     *
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, AdminUser $adminUser)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AdminUserType::class, $adminUser, [
            'password_encoder' => $this->get('security.password_encoder')
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $adminUser->setUpdatedAt(new \DateTime());
            $em->flush();

            return $this->redirectToRoute('users_index');
        }

        return [
            'form' => $form->createView(),
            'formHeader' => 'User create/edit',
            'formClass' => 'user-form'
        ];
    }

    /**
     * @Route("/{id}/delete", name="user_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     * @Template("AppBundle::delete.html.twig")
     *
     * @param Request $request
     * @param AdminUser $adminUser
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, AdminUser $adminUser)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', ['id' => $adminUser->getId()]))
            ->setMethod('DELETE')
            ->getForm();

        if ($request->getMethod() == Request::METHOD_GET) {
            return [
                'form' => $form->createView(),
                'id' => $adminUser->getId()
            ];
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adminUser);
            $em->flush();

            $this->addFlash('success', 'User was deleted');
        } else {
            $this->addFlash('danger', 'User didn\'t deleted');
        }

        return $this->redirectToRoute('users_index');
    }
}
