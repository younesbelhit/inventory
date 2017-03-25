<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SalesOrderHeader;
use AppBundle\Entity\SalesPayment;
use AppBundle\Form\Type\SalesOrderHeaderType;
use AppBundle\Form\Type\SalesPaymentType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderController extends Controller
{
    /**
     * @Route("/list/sales.order/", name="salesOrder")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrder = $em->getRepository('AppBundle:SalesOrderHeader')->findAll();
        return $this->render('salesOrder/list.html.twig', ['salesOrder' => $salesOrder]);
    }

    /**
     * @Route("/sales.order/create/", name="create_salesOrder")
     */
    public function createAction(Request $request)
    {
        $salesOrderHeader = new SalesOrderHeader();

        $em = $this->getDoctrine()->getManager();

        $lastSalesOrderNumber = $em->getRepository('AppBundle:SalesOrderHeader')->getLastSalesOrderNumber();
        $lastSalesOrderNumber = !empty($lastSalesOrderNumber[0]['salesOrderNumber']) ? $lastSalesOrderNumber[0]['salesOrderNumber'] : 0;
        $lastSalesOrderNumber++;
        $salesOrderNumber = ($lastSalesOrderNumber < 10) ? sprintf('00%s', $lastSalesOrderNumber) :  sprintf('0%s', $lastSalesOrderNumber);
        $salesOrderHeader->setSalesOrderNumber($salesOrderNumber);
        $salesOrderHeader->setUser($this->get('security.token_storage')->getToken()->getUser());

        $form = $this->createForm(SalesOrderHeaderType::class, $salesOrderHeader);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {

            foreach ($salesOrderHeader->getSalesOrderDetail() as $salesOrderDetail)
            {
                $salesOrderDetail->getProduct()->setAmount($salesOrderDetail->getProduct()->getAmount() - $salesOrderDetail->getOrderQty());
                $salesOrderDetail->setLineTotal($salesOrderDetail->getUnitPrice()*$salesOrderDetail->getOrderQty());
                $salesOrderHeader->setTotalHT($salesOrderHeader->getTotalHT() + $salesOrderDetail->getLineTotal());
                $salesOrderHeader->setTotalTTC($salesOrderHeader->getTotalHT() *  ( 1 + $salesOrderDetail->getProduct()->getTva()/100 ));

            }

            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('view_salesOrder', array('id' => $salesOrderHeader->getId()));

        }

        return $this->render('salesOrder/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/sales.order/{id}", name="view_salesOrder",  defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function viewAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrderHeader = $em->getRepository('AppBundle:SalesOrderHeader')->findOneById($id);

        if (!$salesOrderHeader) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $originalSalesOrderDetail = new ArrayCollection();

        foreach ($salesOrderHeader->getSalesOrderDetail() as $salesOrderDetail) {
            $originalSalesOrderDetail->add($salesOrderDetail);
        }

        return $this->render('salesOrder/view.html.twig', array('salesOrderHeader' => $salesOrderHeader));
    }

    /**
     * @Route("/sales.order/edit/{id}", name="edit_salesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrderHeader = $em->getRepository('AppBundle:SalesOrderHeader')->find($id);

        if (!$salesOrderHeader) {
            throw $this->createNotFoundException('No PurchaseOrderHeader found for id '.$id);
        }

        $originalSalesOrderDetail = new ArrayCollection();

        // Create an ArrayCollection of the current SalesOrderDetail objects in the database
        foreach ($salesOrderHeader->getSalesOrderDetail() as $salesOrderDetail) {
            $originalSalesOrderDetail->add($salesOrderDetail);
        }

        $form = $this->createForm(SalesOrderHeaderType::class, $salesOrderHeader);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {

            foreach ($originalSalesOrderDetail as $salesOrderDetail) {
                if (false === $salesOrderHeader->getSalesOrderDetail()->contains($salesOrderDetail)) {
                    $salesOrderDetail->setSalesOrderHeader(null);
                    $em->persist($salesOrderDetail);
                }
            }

            foreach ($salesOrderHeader->getSalesOrderDetail() as $salesOrderDetail)
            {
                $salesOrderDetail->getProduct()->setAmount($salesOrderDetail->getProduct()->getAmount() - $salesOrderDetail->getOrderQty());
                $salesOrderDetail->setLineTotal($salesOrderDetail->getUnitPrice()*$salesOrderDetail->getOrderQty());
                $salesOrderHeader->setTotalHT($salesOrderHeader->getTotalHT() + $salesOrderDetail->getLineTotal());
                $salesOrderHeader->setTotalTTC($salesOrderHeader->getTotalHT() *  ( 1 + $salesOrderDetail->getProduct()->getTva()/100 ));
            }

            $em->persist($salesOrderHeader);
            $em->flush();

            return $this->redirectToRoute('edit_salesOrder', array('id' => $id));

        }

        return $this->render('salesOrder/edit.html.twig', array('form' => $form->createView(), 'salesOrderHeader' => $salesOrderHeader));
    }


    /**
     * @Route("/sales.order/remove/{id}", name="remove_SalesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrder = $em->getRepository('AppBundle:SalesOrderHeader')->find($id);

        if (!$salesOrder) {
            throw $this->createNotFoundException('No SalesOrderHeader found for id '.$id);
        }

        $em->remove($salesOrder);
        $em->flush();

        return $this->redirectToRoute('salesOrder');
    }

    /**
     * @Route("/sales.order/print/{id}", name="print_salesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function printAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrderHeader = $em->getRepository('AppBundle:SalesOrderHeader')->find($id);

        if (!$salesOrderHeader) {
            throw $this->createNotFoundException('No SalesOrderHeader found for id '.$id);
        }

        $originalSalesOrderDetail = new ArrayCollection();

        foreach ($salesOrderHeader->getSalesOrderDetail() as $salesOrderDetail) {
            $originalSalesOrderDetail->add($salesOrderDetail);
        }

        $form = $this->createForm(SalesOrderHeaderType::class, $salesOrderHeader);
        $form->handleRequest($request);

        foreach ($originalSalesOrderDetail as $salesOrderDetail) {
            if (false === $salesOrderHeader->getSalesOrderDetail()->contains($salesOrderDetail)) {
                $salesOrderDetail->getPurchaseOrderHeader()->removeElement($salesOrderHeader);
            }
        }

        $html = $this->renderView('salesOrder/print.html.twig', ['salesOrderHeader' => $salesOrderHeader]);
        return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array('Content-Type' => 'application/pdf'));
    }

    /**
     * @Route("/sales.order/{id}/confirm", name="confirm_salesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function confirmSalesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:SalesOrderHeader')->confirmSales($id);
        return $this->redirectToRoute('view_salesOrder', array('id' => $id));

    }


    /**
     * @Route("/sales.order/{id}/invoice", name="invoice_salesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function invoiceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrder = $em->getRepository('AppBundle:SalesOrderHeader')->find($id);
        $form = $this->createForm(SalesPaymentType::class, new SalesPayment());

        if (!$salesOrder) {
            throw $this->createNotFoundException('No SalesOrderHeader found for id ' . $id);
        }

        return $this->render('salesOrder/invoice.html.twig', array(
            'form' => $form->createView(),
            'salesOrder' => $salesOrder
        ));

    }

    /**
     * @Route("/sales.order/{id}/invoice/validate", name="invoiceValidate_salesOrder", defaults={"id": ""}, requirements={"id": "\d+"})
     */
    public function invoiceValidate_salesOrderAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:SalesOrderHeader')->invoiceValidate($id);
        return $this->redirectToRoute('invoice_salesOrder', array('id' => $id));
    }

}
