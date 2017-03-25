<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tva;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTvaData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $tva = array(
            '7%'  => '0.07',
            '10%' => '0.1',
            '14%' => '0.14',
            '20%' => '0.2'
        );

        $user = new Tva();
        foreach($tva as $code => $taux) {
            $user->setCode($code);
            $user->setTaux($taux);
            $manager->persist($user);
        }

        $manager->flush();
    }
}