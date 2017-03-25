<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProductPhoto;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Customer;

class LoadCustomerData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $customer = new Customer();

        $customer->setName('John Doe');
        $customer->setEmail('john.doe@contact.com');
        $customer->setAddress('58 Hunt Dr, Kearneysville, WV, 25430');
        $customer->setCity('Churubusco');
        $customer->setCellphone('(260) 693-4159');
        $customer->setPhone('(260) 693-4159');
        $customer->setCountry('United state');
        $customer->setFax('(859) 332-9052');
        $customer->setPostalCode('502');
        $customer->setWebsite('wetransfer.com/#');
        $customer->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque semper vehicula est. 
                Vestibulum sagittis leo ut diam eleifend, egestas ultricies nibh bibendum. 
                Phasellus imperdiet convallis hendrerit.');

        $manager->persist($customer);
        $manager->flush();
    }
}