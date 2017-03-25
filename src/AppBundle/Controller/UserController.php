<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;

class UserController extends Controller
{
    /**
     * @Route("/{view}/user", name="user", defaults={"view": "kanban"})
     */
    public function indexAction(Request $request, $view)
    {
        $userManager =  $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render("user/$view.html.twig", ['users' => $users]);
    }

    /**
     * @Route("/user/import", name="import_user")
     */
    public function importAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('file', FileType::class, array( 'required' => true ))
            ->getForm();

        if( $form->isSubmitted() && $form->isValid() ) {
            dump($request);
            exit();
        }

        return $this->render('user/import.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * @Route("/user/remove/{id}", name="remove_user", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(['id' => $id]);

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user', ['view' => 'list']);
    }
}
