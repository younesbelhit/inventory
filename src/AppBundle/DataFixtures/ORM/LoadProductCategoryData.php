<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProductCategory;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $productCategory = new ProductCategory();
        $productCategory->setName('Téléphones & Tablettes');
        $productCategory->setName('TV & Multimedia');

        $manager->persist($productCategory);
        $manager->flush();
    }
}