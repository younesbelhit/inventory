<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Supplier;
use AppBundle\Entity\SupplierPhoto;
use AppBundle\Form\Type\SupplierType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    /**
     * @Route("/{view}/supplier/", name="supplier", defaults={"view": "kanban"})
     */
    public function listAction(Request $request, $view)
    {
        $em = $this->getDoctrine()->getManager();
        $suppliers = $em->getRepository('AppBundle:Supplier')->findBy([], ['id' => 'DESC']);
        return $this->render("supplier/$view.html.twig", ['suppliers' => $suppliers]);
    }

    /**
     * @Route("/supplier/create", name="create_supplier")
     */
    public function createAction(Request $request)
    {
        $supplier = new Supplier();
        $supplierPhoto = new SupplierPhoto();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $file = $supplier->getPhoto();
            $fileName = null;

            if( isset($request->files->get('supplier')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
            }

            $supplierPhoto->setThumbnailPhotoFileName($fileName);
            $supplier->setPhoto($supplierPhoto);

            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('create_supplier');

        }

        return $this->render('supplier/create.html.twig', ['form' => $form->createView()]);
    }



    public function createContentAction(Request $request)
    {
        $form = $this->createForm(SupplierType::class, new Supplier());
        return $this->render('supplier/create_content.html.twig', array('form' => $form->createView()));

    }


    /**
     * @Route("/supplier/edit/{id}", name="edit_supplier", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $supplierPhoto = new SupplierPhoto();

        $supplier = $em->getRepository('AppBundle:Supplier')->find($id);
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $file = $supplier->getPhoto();
            $fileName = null;

            if( isset($request->files->get('supplier')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
            }

            $supplierPhoto->setThumbnailPhotoFileName($fileName);
            $supplier->setPhoto($supplierPhoto);

            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('supplier', ['view' => 'list']);

        }

        return $this->render('supplier/edit.html.twig', ['form' => $form->createView(), 'supplier' => $supplier]);
    }

    /**
     * @Route("/supplier/{id}", name="view_$supplierPhoto", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, $id)
    {
        $supplierManager = $this->get('vendor.manager');
        $supplier = $supplierManager->findOneById($id);
        return $this->render('supplier/view.html.twig', ['supplier' => $supplier]);
    }

    /**
     * @Route("/supplier/remove/{id}", name="remove_supplier", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $supplierManager = $this->get('vendor.manager');
        $supplierManager->remove($id);
        return $this->redirectToRoute('supplier', ['view' => 'list']);
    }

    /**
     * @Route("/supplier/import/", name="import_supplier")
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

        return $this->render('supplier/import.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * @Route("/supplier/duplicate/{id}", name="duplicate_supplier", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function duplicateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository('AppBundle:Supplier')->find($id);

        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $em->persist($form->getData());
            $em->flush();

        }

        return $this->render('supplier/duplicate.html.twig', [ 'form' => $form->createview(), 'supplier' => $supplier ]);
    }


    /**
     * @Route("/supplier/print/{id}", name="print_supplier", defaults={"id": ""} ,requirements={"id": "\d+"})
     */
    public function printAction(Request $request, $id)
    {
        return $this->render('supplier/print.html.twig');
    }

    /**
     * @Route("/supplier/pdf", name="pdf_supplier")
     */
    public function pdfAction(Request $request)
    {
        $customerManager = $this->get('vendor.manager');
        $suppliers = $customerManager->findVendors();
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView('supplier/pdf.html.twig', ['suppliers' => $suppliers])
            ),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="fournisseurs.pdf"'
            )
        );
    }

    /**
     * @Route("/supplier/excel", name="excel_$suppliers")
     */
    public function excelAction(Request $request)
    {

    }


}
