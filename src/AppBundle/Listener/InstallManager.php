<?php

namespace AppBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class InstallManager {

    /**
     * @var Router
     */
    private $router;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var RequestStack
     */
    private $request;

    /**
     * InstallManager constructor.
     */
    public function __construct(Router $router, EventDispatcherInterface $dispatcher, Container $container, RequestStack $request) {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
        $this->request = $request;
    }

    public function onKernelResponse() {
        $this->dispatcher->addListener(KernelEvents::RESPONSE, array($this, 'onKernelRequest'));
    }

    public function onKernelRequest(FilterResponseEvent $event) {
        if(empty($this->container->get('company.manager')->has_company()))
            $event->setResponse(new RedirectResponse($this->router->generate('setup_config')));
    }



}