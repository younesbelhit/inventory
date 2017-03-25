<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProductPhoto
 *
 * @ORM\Table(name="product_photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductPhotoRepository")
 * @Vich\Uploadable
 */
class ProductPhoto
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
     * @return ProductPhoto
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

