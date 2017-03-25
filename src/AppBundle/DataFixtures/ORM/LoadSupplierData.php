<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Supplier;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSupplierData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $supplier = new Supplier();

        $supplier->setName('John Doe');
        $supplier->setEmail('john.doe@contact.com');
        $supplier->setAddress('58 Hunt Dr, Kearneysville, WV, 25430');
        $supplier->setCity('Churubusco');
        $supplier->setCellphone('(260) 693-4159');
        $supplier->setPhone('(260) 693-4159');
        $supplier->setCountry('United state');
        $supplier->setFax('(859) 332-9052');
        $supplier->setPostalCode('502');
        $supplier->setWebsite('wetransfer.com/#');
        $supplier->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque semper vehicula est. 
                Vestibulum sagittis leo ut diam eleifend, egestas ultricies nibh bibendum. 
                Phasellus imperdiet convallis hendrerit.');

        $manager->persist($supplier);
        $manager->flush();
    }
}