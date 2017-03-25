<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductPhoto;
use AppBundle\Form\Type\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProductController extends Controller
{
    /**
     * @Route("/{view}/product/", name="product", defaults = {"view": "kanban"})
     */
    public function indexAction(Request $request, $view)
    {
        $productManager = $this->get('product.manager');
        $products = $productManager->findProducts();
        return $this->render("product/$view.html.twig", ['products' => $products]);
    }

    /**
     * @Route("/product/create/", options = { "expose" = true }, name="create_product")
     */
    public function createAction(Request $request, $id = null)
    {
        $product = new Product();
        $productPhoto = new ProductPhoto();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $file = $product->getPhoto();
            $fileName = null;

            if( isset($request->files->get('product')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
            }

            $productPhoto->setThumbnailPhotoFileName($fileName);
            $product->setPhoto($productPhoto);
            $em->persist($form->getData());
            $em->flush();

            return new JsonResponse(array('status' => true));

        }

        return $this->render('product/create.html.twig', [ 'form' => $form->createView() ]);
    }

    /**
     * @Route("/product/edit/{id}/{slug}", name="edit_product", defaults={"id": "", "slug": ""}, requirements={"id": "\d+"})
     */
    public function editAction(Request $request, $id, $slug)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->findOneBy(['id' => $id, 'slug' => $slug], []);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('product', ['view' => 'list']);

        }

        return $this->render('product/edit.html.twig', ['product' => $product, 'form' => $form->createview()]);
    }

    /**
     * @Route("/product/remove/{id}", name="remove_product", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $productManager = $this->get('product.manager');
        $productManager->remove($id);
        return $this->redirectToRoute('product', ['view' => 'list']);
    }

    /**
     * @Route("/product/getInfo/{id}", name="getinfo_product", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function getInfoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->getInfo($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->serialize($product, 'json'); 
        
        return new JsonResponse($data);
    }

    /**
     * @Route("/product/{id}/{slug}", name="view_product", defaults={"id": "", "slug": ""}, requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->findOneBy(['id' => $id, 'slug' => $slug], []);
        return $this->render('product/view.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product/import/", name="import_product")
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

        return $this->render('product/import.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * @Route("/product/export/", name="export_product")
     */
    public function exportAction(Request $request)
    {
        $objPHPExcel = new \PHPExcel();
        $objSheet = $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        return new Response(
            $objWriter->save('product.xlsx'),
            200,
            array(
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="doc.xlsx"',
            )
        );
    }

    /**
     * @Route("/product/print/", name="pdf_product")
     */
    public function pdfAction(Request $request)
    {
        $productManager = $this->get('product.manager');
        $products = $productManager->findProducts();
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView('product/pdf.html.twig', ['products' => $products])
            ),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="produit.pdf"'
            )
        );
    }

    /**
     * @Route("/product/print/{id}", name="print_product", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function printAction(Request $request, $id)
    {
        $productManager = $this->get('product.manager');
        $product = $productManager->findOneById($id);
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView('product/print.html.twig', ['product' => $product])
            ),
            200,
            array( 'Content-Type' => 'application/pdf' )
        );
    }
    
    /**
     * @Route("/product/duplicate/{id}", name="duplicate_product", defaults={"id": ""}, requirements={"id": "\d+"})
     */
     public function duplicateAction(Request $request, $id)
     {
         $em = $this->getDoctrine()->getManager();
         $product = $em->getRepository('AppBundle:Product')->find($id);

         $form = $this->createForm(ProductType::class, $product);
         $form->handleRequest($request);

         if( $form->isSubmitted() && $form->isValid() ) {

             $em->persist($form->getData());
             $em->flush();

         }

         return $this->render('product/duplicate.html.twig', [ 'form' => $form->createview(), 'product' => $product ]);
     }

}
