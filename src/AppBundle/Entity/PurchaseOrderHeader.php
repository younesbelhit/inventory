<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PurchaseOrderHeader
 *
 * @ORM\Table(name="purchase_order_header")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseOrderHeaderRepository")
 */
class PurchaseOrderHeader
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="purchaseOrderHeader")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="purchaseOrderHeader")
     * @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     */
    private $supplier;

    /**
     * @var string
     *
     * @ORM\Column(name="supplierNumber", type="string", length=255, nullable=true)
     */
    private $supplierNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="purchaseOrderNumber", type="string", length=255)
     */
    private $purchaseOrderNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=true, options={"default" : 1})
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="date")
     */
    private $orderDate;

    /**
     * @var float
     *
     * @ORM\Column(name="totalHT", type="float", nullable=true)
     */
    private $totalHT;

    /**
     * @var float
     *
     * @ORM\Column(name="totalTTC", type="float", nullable=true)
     */
    private $totalTTC;

    /**
     * @var \DateTime()
     *
     * @ORM\Column(name="shipDate", type="date", nullable=true)
     */
    private $shipDate;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseOrderDetail", mappedBy="purchaseOrderHeader", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $purchaseOrderDetail;

    /**
     * @ORM\OneToMany(targetEntity="PurchasePayment", mappedBy="purchaseOrderHeader", cascade={"persist", "remove"})
     */
    private $purchasePayment;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param string $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return string
     */
    public function getSupplierNumber()
    {
        return $this->supplierNumber;
    }

    /**
     * @param string $supplierNumber
     */
    public function setSupplierNumber($supplierNumber)
    {
        $this->supplierNumber = $supplierNumber;
    }

    /**
     * Set purchaseOrderNumber
     *
     * @param string $purchaseOrderNumber
     *
     * @return PurchaseOrderHeader
     */
    public function setPurchaseOrderNumber($purchaseOrderNumber)
    {
        $this->purchaseOrderNumber = $purchaseOrderNumber;

        return $this;
    }

    /**
     * Get purchaseOrderNumber
     *
     * @return string
     */
    public function getPurchaseOrderNumber()
    {
        return $this->purchaseOrderNumber;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return PurchaseOrderHeader
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param float $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     *
     * @return PurchaseOrderHeader
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set totalTTC
     *
     * @param float $totalTTC
     *
     * @return PurchaseOrderHeader
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return float
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * @return mixed
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }

    /**
     * @param mixed $shipDate
     */
    public function setShipDate($shipDate)
    {
        $this->shipDate = $shipDate;
    }

    /**
     * @return mixed
     */
    public function getPurchasePayment()
    {
        return $this->purchasePayment;
    }

    /**
     * @param mixed $purchasePayment
     */
    public function setPurchasePayment($purchasePayment)
    {
        $this->purchasePayment = $purchasePayment;
    }

    /**
     * Set purchaseOrderDetail
     */
    public function setPurchaseOrderDetail(PurchaseOrderDetail $purchaseOrderDetail)
    {
        $this->purchaseOrderDetail = $purchaseOrderDetail;
    }

    /**
     * @return mixed
     */
    public function getPurchaseOrderDetail()
    {
        return $this->purchaseOrderDetail;
    }

    public function addPurchaseOrderDetail(PurchaseOrderDetail $purchaseOrderDetail)
    {
        $purchaseOrderDetail->addPurchaseOrderHeader($this);
        $this->purchaseOrderDetail->add($purchaseOrderDetail);
    }

    public function removePurchaseOrderDetail(PurchaseOrderDetail $purchaseOrderDetail)
    {
        $this->purchaseOrderDetail->removeElement($purchaseOrderDetail);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * PurchaseOrderHeader constructor.
     */
    public function __construct()
    {
        $this->status = 0;
        $this->createdAt = new \DateTime('now');
        $this->purchaseOrderDetail = new ArrayCollection();
    }

}

