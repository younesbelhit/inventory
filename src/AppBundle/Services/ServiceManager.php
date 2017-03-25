<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;


class ServiceManager {

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var Router
     */
    private $router;

    /**
     * ProductManager constructor.
     *
     * @param EntityManager $entityManager
     * @param Container $container
     * @param Router $router
     * @param RequestStack $request
     */
    public function __construct(EntityManager $entityManager, Container $container, Router $router ,RequestStack $request) {
        $this->em = $entityManager;
        $this->container = $container;
        $this->router = $router;
        $this->request = $request;
    }



}
