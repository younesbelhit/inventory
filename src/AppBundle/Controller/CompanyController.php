<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\Type\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

    /**
     * @Route("/company/", name="company")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('AppBundle:Company')->getInfo();
        $form = $this->createForm(CompanyType::class, $company);
        $form->remove('submit');
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('company');

        }

        return $this->render('company/index.html.twig', ['form' => $form->createView(), 'company' => $company]);

    }


    /**
     * @Route("/setup/config/", name="setup_config", requirements={})
     */
    public function setupAction(Request $request) {

            if(!empty($this->get('company.manager')->has_company()))
                return new RedirectResponse($this->get('router')->generate('dashboard'));

            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(CompanyType::class, new Company());
            $form->handleRequest($request);

            if( $form->isSubmitted() && $form->isValid() ) {

                $em->persist($form->getData());
                $em->flush();
            return $this->redirectToRoute('fos_user_security_login');

        }
        return $this->render('install/index.html.twig', ['form' => $form->createView()]);
    }


}
