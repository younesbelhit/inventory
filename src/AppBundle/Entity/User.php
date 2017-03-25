<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="cellPhone", type="string", length=255, nullable=true)
     */
    protected $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseOrderHeader", mappedBy="user")
     */
    private $purchaseOrderHeader;

    /**
     * @ORM\OneToMany(targetEntity="SalesOrderHeader", mappedBy="user")
     */
    private $salesOrderHeader;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * @param string $cellPhone
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
    }

    /**
     * @return float
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param float $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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


    public function __construct()
    {
        parent::__construct();
    }


}