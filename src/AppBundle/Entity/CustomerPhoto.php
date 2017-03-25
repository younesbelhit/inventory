<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerPhoto
 *
 * @ORM\Table(name="customer_photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerPhotoRepository")
 */
class CustomerPhoto
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
     * @return CustomerPhoto
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

