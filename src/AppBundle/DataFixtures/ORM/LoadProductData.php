<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProductPhoto;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $productPhoto = new ProductPhoto();

        $product->setName('Infinix Zero 4 X555 – 4G – 32 Go – 3 Go Ram - Android 6,0 – Gold');
        $product->setFinishedGoodsFlg(1);
        $product->setNumber('IN339ELOLAQMNAFAMZ');
        $product->setSellingPrice(2599);
        $product->setPhoto($productPhoto->setThumbnailPhotoFileName('https://static.jumia.ma/p/infinix-0987-81990571-1-product.jpg'));
        $product->setQuantity(50);
        $product->setDescription('Infinix Zero 4 vous impressionne par la clarté époustouflante des photos et vidéos rendue possible grâce à la stabilisation optique de l\'image (OIS). Cette technologie contribue à prévenir les mouvements de main et le faible flou de lumière qui ruinent souvent le prise de vue parfaite.');
        $product->setCreatedAt(new \DateTime('now'));

        $manager->persist($product);
        $manager->flush();
    }
}