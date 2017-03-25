<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SalesOrderHeader
 *
 * @ORM\Table(name="sales_order_header")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalesOrderHeaderRepository")
 */
class SalesOrderHeader
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="salesOrderHeader")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="salesOrderHeader")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="customerNumber", type="string", length=255, nullable=true)
     */
    private $customerNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="salesOrderNumber", type="string", length=255)
     */
    private $salesOrderNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=true)
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
     * @ORM\OneToMany(targetEntity="SalesOrderDetail", mappedBy="salesOrderHeader", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $salesOrderDetail;

    /**
     * @ORM\OneToMany(targetEntity="SalesPayment", mappedBy="salesOrderHeader", cascade={"persist", "remove"})
     */
    private $salesPayment;

    /**
     * @ORM\Column(type="datetime", name="created_at")
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
     * Set customer
     *
     * @param string $customer
     *
     * @return SalesOrderHeader
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    /**
     * @param string $customerNumber
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber = $customerNumber;
    }

    /**
     * Set salesOrderNumber
     *
     * @param string $salesOrderNumber
     *
     * @return SalesOrderHeader
     */
    public function setSalesOrderNumber($salesOrderNumber)
    {
        $this->salesOrderNumber = $salesOrderNumber;

        return $this;
    }

    /**
     * Get salesOrderNumber
     *
     * @return string
     */
    public function getSalesOrderNumber()
    {
        return $this->salesOrderNumber;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return SalesOrderHeader
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
     * @param \DateTime $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @param \DateTime $orderDate
     */
    public function setSalesOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * @param float $totalHT
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;
    }

    /**
     * @return float
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * @param float $totalTTC
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;
    }

    /**
     * @return \DateTime
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }

    /**
     * @param \DateTime $shipDate
     */
    public function setShipDate($shipDate)
    {
        $this->shipDate = $shipDate;
    }

    /**
     * @return mixed
     */
    public function getSalesPayment()
    {
        return $this->salesPayment;
    }

    /**
     * @param mixed $salesPayment
     */
    public function setSalesPayment($salesPayment)
    {
        $this->salesPayment = $salesPayment;
    }

    /**
     * @param mixed $salesOrderDetail
     */
    public function setSalesOrderDetail(SalesOrderDetail $salesOrderDetail)
    {
        $this->salesOrderDetail = $salesOrderDetail;
    }

    /**
     * @return mixed
     */
    public function getSalesOrderDetail()
    {
        return $this->salesOrderDetail;
    }

    public function addSalesOrderDetail(SalesOrderDetail $salesOrderDetail)
    {
        $salesOrderDetail->addSalesOrderHeader($this);
        $this->salesOrderDetail->add($salesOrderDetail);
    }

    public function removeSalesOrderDetail(SalesOrderDetail $salesOrderDetail)
    {
        $this->salesOrderDetail->removeElement($salesOrderDetail);
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
     * SalesOrderHeader constructor.
     */
    public function __construct()
    {
        $this->status = 0;
        $this->createdAt = new \DateTime('now');
        $this->salesOrderDetail = new ArrayCollection();
    }
}

