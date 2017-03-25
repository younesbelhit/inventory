<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierPhoto
 *
 * @ORM\Table(name="supplier_photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SupplierPhotoRepository")
 */
class SupplierPhoto
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
     * @ORM\Column(name="thumbnailPhotoFileName", type="string", length=255, nullable=true)
     */
    private $thumbnailPhotoFileName;


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
     * Set thumbnailPhotoFileName
     *
     * @param string $thumbnailPhotoFileName
     *
     * @return VendorPhoto
     */
    public function setThumbnailPhotoFileName($thumbnailPhotoFileName)
    {
        $this->thumbnailPhotoFileName = $thumbnailPhotoFileName;

        return $this;
    }

    /**
     * Get thumbnailPhotoFileName
     *
     * @return string
     */
    public function getThumbnailPhotoFileName()
    {
        return $this->thumbnailPhotoFileName;
    }
}

