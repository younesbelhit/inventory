<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PurchaseOrderDetail
 *
 * @ORM\Table(name="purchase_order_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseOrderDetailRepository")
 */
class PurchaseOrderDetail
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="purchaseOrderDetail", fetch="EAGER")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="orderQty", type="integer", nullable=true)
     */
    private $orderQty;

    /**
     * @var float
     *
     * @ORM\Column(name="unitPrice", type="float", nullable=true)
     */
    private $unitPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="lineTotal", type="float", nullable=true)
     */
    private $lineTotal;

    /**
     * @ORM\ManyToOne(targetEntity="PurchaseOrderHeader", inversedBy="purchaseOrderDetail")
     * @ORM\JoinColumn(name="purchaseOrderHeader_id", referencedColumnName="id")
     */
    private $purchaseOrderHeader;


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
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }


    /**
     * Set orderQty
     *
     * @param integer $orderQty
     *
     * @return PurchaseOrderDetail
     */
    public function setOrderQty($orderQty)
    {
        $this->orderQty = $orderQty;

        return $this;
    }

    /**
     * Get orderQty
     *
     * @return int
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
     * @return PurchaseOrderDetail
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
     * @return PurchaseOrderDetail
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
    public function getPurchaseOrderHeader()
    {
        return $this->purchaseOrderHeader;
    }

    /**
     * @param mixed $purchaseOrderHeader
     */
    public function setPurchaseOrderHeader($purchaseOrderHeader)
    {
        $this->purchaseOrderHeader = $purchaseOrderHeader;
    }

    public function addPurchaseOrderHeader(PurchaseOrderHeader $purchaseOrderHeader)
    {
        $this->setPurchaseOrderHeader($purchaseOrderHeader);
    }


}

