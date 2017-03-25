<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        return $this->render('dashboard/dashboard.html.twig');
    }

    /**
     * @Route("/error", name="error")
     */
    public function errorAction(Request $request)
    {
        return $this->render('dashboard/404.html.twig');
    }
}
