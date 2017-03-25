<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\PurchaseOrderHeader;
use AppBundle\Entity\PurchaseOrderDetail;
use AppBundle\Form\Type\PurchaseOrderHeaderType;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Form\Type\PurchasePaymentType;
use AppBundle\Entity\PurchasePayment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class PurchaseOrderController extends Controller
{
    /**
     * @Route("/list/purchase.order/", name="purchaseOrder")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrder = $em->getRepository('AppBundle:PurchaseOrderHeader')->findBy([], ['id' => 'DESC']);
        return $this->render('purchaseOrder/list.html.twig', ['purchaseOrder' => $purchaseOrder]);
    }

    /**
     * @Route("/purchase.order/create/", name="create_purchaseOrder")
     */
    public function createAction(Request $request)
    {
        $purchaseOrderHeader = new PurchaseOrderHeader();

        $em = $this->getDoctrine()->getManager();

        $lastPurchaseOrderNumber = $em->getRepository('AppBundle:PurchaseOrderHeader')->getLastPurcharseOrderNumber();
        $lastPurchaseOrderNumber = !empty($lastPurchaseOrderNumber[0]['purchaseOrderNumber']) ? $lastPurchaseOrderNumber[0]['purchaseOrderNumber'] : 0;
        $lastPurchaseOrderNumber++;
        $purchaseOrderNumber = ($lastPurchaseOrderNumber < 10) ? sprintf('00%s', $lastPurchaseOrderNumber) :  sprintf('0%s', $lastPurchaseOrderNumber);
        $purchaseOrderHeader->setPurchaseOrderNumber($purchaseOrderNumber);
        $purchaseOrderHeader->setUser($this->get('security.token_storage')->getToken()->getUser());

        $form = $this->createForm(PurchaseOrderHeaderType::class, $purchaseOrderHeader);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            if( sizeof($purchaseOrderHeader->getPurchaseOrderDetail()) < 1 ) {
                return new JsonResponse(array(
                    'message' => 'Vous devez au moins ajouter un produit à cet commande !'
                ));
            }

            foreach ($purchaseOrderHeader->getPurchaseOrderDetail() as $purchaseOrderDetail) {
                $purchaseOrderDetail->getProduct()->setAmount($purchaseOrderDetail->getProduct()->getAmount() + $purchaseOrderDetail->getOrderQty());
                $purchaseOrderDetail->setLineTotal($purchaseOrderDetail->getUnitPrice()*$purchaseOrderDetail->getOrderQty());
                $purchaseOrderHeader->setTotalHT($purchaseOrderHeader->getTotalHT() + $purchaseOrderDetail->getLineTotal());
                $purchaseOrderHeader->setTotalTTC($purchaseOrderHeader->getTotalHT() *  ( 1 + $purchaseOrderDetail->getProduct()->getTva()/100 ));
            }

            $em->persist($form->getData());
            $em->flush();

           return $this->redirectToRoute('view_purchaseOrder', array('id' => $purchaseOrderHeader->getId()));

        }

        return $this->render('purchaseOrder/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/purchase.order/{id}", name="view_purchaseOrder",  defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrderHeader = $em->getRepository('AppBundle:PurchaseOrderHeader')->findOneById($id);

        if (!$purchaseOrderHeader) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $originalPurchaseOrderDetail = new ArrayCollection();

        foreach ($purchaseOrderHeader->getPurchaseOrderDetail() as $purchaseOrderDetail) {
            $originalPurchaseOrderDetail->add($purchaseOrderDetail);
        }

        return $this->render('purchaseOrder/view.html.twig', array('purchaseOrderHeader' => $purchaseOrderHeader));
    }


    /**
     * @Route("/purchase.order/edit/{id}", name="edit_purchaseOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrderHeader = $em->getRepository('AppBundle:PurchaseOrderHeader')->find($id);

        if (!$purchaseOrderHeader) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $originalPurchaseOrderDetail = new ArrayCollection();

        // Create an ArrayCollection of the current PurchaseOrderDetail objects in the database
        foreach ($purchaseOrderHeader->getPurchaseOrderDetail() as $purchaseOrderDetail) {
            $originalPurchaseOrderDetail->add($purchaseOrderDetail);
        }

        $form = $this->createForm(PurchaseOrderHeaderType::class, $purchaseOrderHeader);
        $form->handleRequest($request);


        if( $form->isSubmitted() && $form->isValid() ) {

            foreach ($originalPurchaseOrderDetail as $purchaseOrderDetail) {
                if (false === $purchaseOrderHeader->getPurchaseOrderDetail()->contains($purchaseOrderDetail)) {
                    $purchaseOrderDetail->setPurchaseOrderHeader(null);
                    $em->persist($purchaseOrderDetail);
                }
            }

            foreach ($purchaseOrderHeader->getPurchaseOrderDetail() as $purchaseOrderDetail) {
                $purchaseOrderDetail->getProduct()->setAmount($purchaseOrderDetail->getProduct()->getAmount() + $purchaseOrderDetail->getOrderQty());
                $purchaseOrderDetail->setLineTotal($purchaseOrderDetail->getUnitPrice()*$purchaseOrderDetail->getOrderQty());
                $purchaseOrderHeader->setTotalHT($purchaseOrderHeader->getTotalHT() + $purchaseOrderDetail->getLineTotal());
                $purchaseOrderHeader->setTotalTTC($purchaseOrderHeader->getTotalHT() *  ( 1 + $purchaseOrderDetail->getProduct()->getTva()/100 ));
            }

            $em->persist($purchaseOrderHeader);
            $em->flush();

            return $this->redirectToRoute('edit_purchaseOrder', array('id' => $id));

        }

        return $this->render('purchaseOrder/edit.html.twig', ['form' => $form->createView(), 'purchaseOrderHeader' => $purchaseOrderHeader]);
    }

    /**
     * @Route("/purchase.order/print/{id}", name="print_purchaseOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function printAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrderHeader = $em->getRepository('AppBundle:PurchaseOrderHeader')->find($id);

        if (!$purchaseOrderHeader) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $originalPurchaseOrderDetail = new ArrayCollection();

        foreach ($purchaseOrderHeader->getPurchaseOrderDetail() as $purchaseOrderDetail) {
            $originalPurchaseOrderDetail->add($purchaseOrderDetail);
        }

        $form = $this->createForm(PurchaseOrderHeaderType::class, $purchaseOrderHeader);
        $form->handleRequest($request);

        foreach ($originalPurchaseOrderDetail as $purchaseOrderDetail) {
            if (false === $purchaseOrderHeader->getPurchaseOrderDetail()->contains($purchaseOrderDetail)) {
                $purchaseOrderDetail->getPurchaseOrderHeader()->removeElement($purchaseOrderHeader);
            }
        }

        $html = $this->renderView('purchaseOrder/print.html.twig', ['purchaseOrderHeader' => $purchaseOrderHeader]);
        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array('Content-Type' => 'application/pdf'));
    }

    /**
     * @Route("/purchase.order/remove/{id}", name="remove_purchaseOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrder = $em->getRepository('AppBundle:PurchaseOrderHeader')->find($id);

        if (!$purchaseOrder) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $em->remove($purchaseOrder);
        $em->flush();

        return $this->redirectToRoute('purchaseOrder');
    }

    /**
     * @Route("/purchase.order/{id}/invoice", name="invoice_purchaseOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function invoiceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchaseOrder = $em->getRepository('AppBundle:PurchaseOrderHeader')->find($id);

        if (!$purchaseOrder) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $form = $this->createForm(PurchasePaymentType::class, new PurchasePayment());
        return $this->render('purchaseOrder/invoice.html.twig', array(
            'form' => $form->createView(),
            'purchaseOrder' => $purchaseOrder
        ));
    }


}
