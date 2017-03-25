<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le nom de produit est obligatoire")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=255, unique=false)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="finishedGoodsFlg", type="boolean", options= { "default": true })
     */
    private $finishedGoodsFlg;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="barCode", type="string", length=255, nullable=true)
     */
    private $barCode;

    /**
     * @var float
     *
     * @ORM\Column(name="status", type="smallint", nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="sellingPrice", type="float", scale=2)
     */
    private $sellingPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * One Product has One Photo.
     * @ORM\OneToOne(targetEntity="ProductPhoto", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_photo_id", referencedColumnName="id")
     */
    private $photo;

    /**
     * Many Product has One Category.
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="product")
     * @ORM\JoinColumn(name="product_category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Many Product has One tva.
     * @ORM\ManyToOne(targetEntity="Tva", inversedBy="product")
     * @ORM\JoinColumn(name="tva_id", referencedColumnName="id")
     */
    private $tva;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseOrderDetail", mappedBy="product")
     */
    private $purchaseOrderDetail;

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set finishedGoodsFlg
     *
     * @param integer $finishedGoodsFlg
     *
     * @return Product
     */
    public function setFinishedGoodsFlg($finishedGoodsFlg)
    {
        $this->finishedGoodsFlg = $finishedGoodsFlg;

        return $this;
    }

    /**
     * Get finishedGoodsFlg
     *
     * @return int
     */
    public function getFinishedGoodsFlg()
    {
        return $this->finishedGoodsFlg;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Product
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set barCode
     *
     * @param string $barCode
     *
     * @return Product
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;

        return $this;
    }

    /**
     * Get barCode
     *
     * @return string
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * @return float
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param float $status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set sellingPrice
     *
     * @param float $sellingPrice
     *
     * @return Product
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    /**
     * Get sellingPrice
     *
     * @return float
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * @param float $tva
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
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
     * @return mixed
     */
    public function getPurchaseOrderDetail()
    {
        return $this->purchaseOrderDetail;
    }

    /**
     * @param mixed $purchaseOrderDetail
     */
    public function setPurchaseOrderDetail($purchaseOrderDetail)
    {
        $this->purchaseOrderDetail = $purchaseOrderDetail;
    }

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }


}

