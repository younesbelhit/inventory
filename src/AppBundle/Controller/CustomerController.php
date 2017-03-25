<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CustomerPhoto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Customer;
use AppBundle\Form\Type\CustomerType;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
   /**
    * @Route("/{view}/customer/", name="customer", defaults={"view": "list"})
    */
    public function indexAction(Request $request, $view)
    {
        $customerManager = $this->get('customer.manager');
        $customers = $customerManager->findCustomers();
        return $this->render("customer/$view.html.twig", array(
            'customers' => $customers
        ));
    }

   /**
    * @Route("/customer/create/", name="create_customer")
    */
    public function createAction(Request $request)
    {
        $customerManager = $this->get('customer.manager');
        if( $customerManager->createCustomer() ) {
            return $this->redirectToRoute('create_customer');
        }
        return $this->render('customer/create.html.twig', array(
            'form' => $customerManager->getForm()->createView()
        ));
    }

    public function createContentAction(Request $request)
    {
        $form = $this->createForm(CustomerType::class, new Customer());
        return $this->render('customer/create_content.html.twig', array('form' => $form->createView()));

    }

   /**
    * @Route("/customer/edit/{id}/{slug}", name="edit_customer", defaults={"id": ""}, requirements={"id": "\d+"})
    */
    public function editAction(Request $request, $id, $slug)
    {

        $customerPhoto = new CustomerPhoto();
        $em = $this->getDoctrine()->getManager();

        $customer = $em->getRepository('AppBundle:Customer')->findOneBy(['id' => $id, 'slug' => $slug], []);
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $file = $customer->getPhoto();
            $fileName = null;

            if( isset($request->files->get('customer')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
            }

            $customerPhoto->setThumbnailPhotoFileName($fileName);
            $customer->setPhoto($customerPhoto);

            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('customer', array('view' => 'list'));

        }

        return $this->render('customer/edit.html.twig', array(
            'form' => $form->createView(),
            'customer' => $customer
        ));

    }

    /**
     * @Route("/customer/{id}/{slug}", name="view_customer", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:Customer')->findOneBy(['id' => $id, 'slug' => $slug], []);
        return $this->render('customer/view.html.twig', array('customer' => $customer));
    }

   /**
    * @Route("/customer/remove/{id}", name="remove_customer", defaults={"id": ""}, requirements={"id": "\d+"})
    */
    public function removeAction(Request $request, $id)
    {
        $customerManager = $this->get('customer.manager');
        $customerManager->remove($id);
        return $this->redirectToRoute('customer', array('view' => 'list'));
    }

    /**
     * @Route("/customer/import/", name="import_customer")
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

        return $this->render('customer/import.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * @Route("/customer/duplicate/{id}", name="duplicate_customer", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function duplicateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:Customer')->find($id);

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $em->persist($form->getData());
            $em->flush();

        }

        return $this->render('customer/duplicate.html.twig', [ 'form' => $form->createview(), 'customer' => $customer ]);
    }


    /**
     * @Route("/customer/print/{id}", name="print_customer", defaults={"id": ""} ,requirements={"id": "\d+"})
     */
    public function printAction(Request $request, $id)
    {
        $customerManager = $this->get('customer.manager');
        $customer = $customerManager->findOneById($id);
        $html = $this->renderView('customer/print.html.twig', array('customer' => $customer));
        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array('Content-Type' => 'application/pdf'));
    }

    /**
     * @Route("/customer/pdf", name="pdf_customer")
     */
    public function pdfAction(Request $request)
    {
        $customerManager = $this->get('customer.manager');
        $customers = $customerManager->findCustomers();
        $html = $this->renderView('customer/pdf.html.twig', array('customers' => $customers));
        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="clients.pdf"'
        ));
    }


    /**
     * @Route("/customer/excel", name="excel_customer")
     */
    public function excelAction(Request $request)
    {

    }

}
