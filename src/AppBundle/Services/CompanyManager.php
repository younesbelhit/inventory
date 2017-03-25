<?php

namespace AppBundle\Services;

use AppBundle\Entity\Company;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RequestStack;

class CompanyManager {

    /**
     * @var Container
     */
    private $container;
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * InstallManager constructor.
     */
    public function __construct(EntityManager $em, Container $container, RequestStack $request) {
        $this->container = $container;
        $this->request = $request;
        $this->em = $em;
    }

    public function create() {
        $this->em->persist(new Company());
        $this->em->flush();
    }

    public function update() {

    }

    public function has_company() {
        return $this->em->getRepository('AppBundle:Company')->findAll();
    }

    public function getInfo() {
        return $this->em->getRepository('AppBundle:Company')->getCompany();
    }

}