<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('younes belhit');
        $user->setEmail('younesbelhit@contact.ma');
        $user->setPlainPassword('1234');
        $user->addRole('ROLE_ADMIN');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
    }
}