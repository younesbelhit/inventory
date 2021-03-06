<?php

namespace AppBundle\Services;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductManager
{

    protected $em;
    protected $request;

    /**
     * ProductManager constructor.
     *
     * @param EntityManager $entityManager
     * @param Form $form
     * @param RequestStack $request
     */
    public function __construct(EntityManager $entityManager, RequestStack $request)
    {
        $this->em = $entityManager;
        $this->request = $request;
    }

    public function findProducts()
    {
        return $this->em->getRepository('AppBundle:Product')->findBy([], ['id' => 'DESC']);
    }

    public function createProduct()
    {
                $request = $this->request->getMasterRequest();
                $this->form->handleRequest($request);

                if($this->form->isSubmitted() && $this->form->isValid()) {

                    $this->em->persist($this->form->getData());
                    $this->flush();
                    return true;

                }else {

            return false;

        }

    }

    public function formView()
    {
        return $this->form->createView();
    }

    public function findOneById($id)
    {
        $product = $this->em->getRepository('AppBundle:Product')->find($id);

        if( !$product ) {
            throw new \Exception('Entity Not found !');
        }

        return $product;
    }


    public function edit()
    {

    }

    public function duplicate($id)
    {

    }

    public function remove($id)
    {
        $product = $this->em->getRepository('AppBundle:Product')->find($id);

        if( !$product ) {
            throw new \Exception('Entity Not Found !');
        }

        $this->em->remove($product);
        $this->flush();
    }

    public function flush()
    {
        $this->em->flush();
    }


}