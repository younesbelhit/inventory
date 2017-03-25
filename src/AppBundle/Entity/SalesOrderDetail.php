<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SalesOrderDetail
 *
 * @ORM\Table(name="sales_order_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalesOrderDetailRepository")
 */
class SalesOrderDetail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="purchaseOrderDetail")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var string
     *
     * @ORM\Column(name="orderQty", type="string", length=255)
     */
    private $orderQty;

    /**
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="float")
     */
    private $unitPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="lineTotal", type="float")
     */
    private $lineTotal;

    /**
     * @ORM\ManyToOne(targetEntity="SalesOrderHeader", inversedBy="salesOrderDetail")
     * @ORM\JoinColumn(name="salesOrderHeader_id", referencedColumnName="id")
     */
    private $salesOrderHeader;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * Set orderQty
     *
     * @param string $orderQty
     *
     * @return SalesOrderDetail
     */
    public function setOrderQty($orderQty)
    {
        $this->orderQty = $orderQty;

        return $this;
    }

    /**
     * Get orderQty
     *
     * @return string
     */
    public function getOrderQty()
    {
        return $this->orderQty;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return SalesOrderDetail
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set lineTotal
     *
     * @param float $lineTotal
     *
     * @return SalesOrderDetail
     */
    public function setLineTotal($lineTotal)
    {
        $this->lineTotal = $lineTotal;

        return $this;
    }

    /**
     * Get lineTotal
     *
     * @return float
     */
    public function getLineTotal()
    {
        return $this->lineTotal;
    }

    /**
     * @return mixed
     */
    public function getSalesOrderHeader()
    {
        return $this->salesOrderHeader;
    }

    /**
     * @param mixed $salesOrderHeader
     */
    public function setSalesOrderHeader($salesOrderHeader)
    {
        $this->salesOrderHeader = $salesOrderHeader;
    }

    public function addSalesOrderHeader(SalesOrderHeader $salesOrderHeader)
    {
        $this->setSalesOrderHeader($salesOrderHeader);
    }



}

