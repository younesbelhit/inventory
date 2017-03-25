<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesPayment
 *
 * @ORM\Table(name="sales_payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalesPaymentRepository")
 */
class SalesPayment
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
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentDate", type="string", length=255)
     */
    private $paymentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentMethod", type="string", length=255)
     */
    private $paymentMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentReference", type="string", length=255)
     */
    private $paymentReference;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="SalesOrderHeader", inversedBy="salesPayment")
     * @ORM\JoinColumn(name="salesPayment_id", referencedColumnName="id")
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
     * Set amount
     *
     * @param float $amount
     *
     * @return SalesPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set paymentDate
     *
     * @param string $paymentDate
     *
     * @return SalesPayment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return SalesPayment
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set paymentReference
     *
     * @param string $paymentReference
     *
     * @return SalesPayment
     */
    public function setPaymentReference($paymentReference)
    {
        $this->paymentReference = $paymentReference;

        return $this;
    }

    /**
     * Get paymentReference
     *
     * @return string
     */
    public function getPaymentReference()
    {
        return $this->paymentReference;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SalesPayment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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

}

