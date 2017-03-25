<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProductCategory;
use AppBundle\Form\Type\ProductCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryController extends Controller
{
    /**
     * @Route("/category/", name="product_category")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:ProductCategory')->findAll();
        return $this->render("productCategory/list.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("/category/create/", name="product_category_create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProductCategoryType::class, new ProductCategory());

        if( $form->isSubmitted() && $form->isValid() ) {

            $em->persist($form->getData());
            $em->flush();

        }

        return $this->render("productCategory/create.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/category/edit/{id}", name="product_category_edit", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $productCategory = $em->getRepository('AppBundle:ProductCategory')->find($id);
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        return $this->render("productCategory/edit.html.twig", ['form' => $form->createView(), 'id' => $id ]);
    }

    /**
     * @Route("/category/remove/{id}", name="product_category_remove", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $productCategory = $em->getRepository('AppBundle:ProductCategory')->find($id);

        if(!$productCategory){
            throw $this->createNotFoundException('product category not found !');
        }

        $em->remove($productCategory);
        $em->flush();

        return $this->redirectToRoute('product_category');

    }

    /**
     * @Route("/category/import/", name="import_product_category")
     */
    public function importAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $productCategory = new ProductCategory();
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        return $this->render("productCategory/import.html.twig", ['form' => $form->createView() ]);
    }


}
