<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchasePayment
 *
 * @ORM\Table(name="purchase_payment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchasePaymentRepository")
 */
class PurchasePayment
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
     * @var \DateTime
     *
     * @ORM\Column(name="paymentDate", type="date")
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
     * @ORM\ManyToOne(targetEntity="PurchaseOrderHeader", inversedBy="purchasePayment")
     * @ORM\JoinColumn(name="purchasePayment_id", referencedColumnName="id")
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
     * Set amount
     *
     * @param float $amount
     *
     * @return PurchasePayment
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
     * @param \DateTime $paymentDate
     *
     * @return PurchasePayment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
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
     * @return PurchasePayment
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
     * @return PurchasePayment
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
     * @return PurchasePayment
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

}

