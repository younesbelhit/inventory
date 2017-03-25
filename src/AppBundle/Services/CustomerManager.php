<?php

namespace AppBundle\Services;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerPhoto;
use AppBundle\Form\Type\CustomerType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomerManager
{

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FormConfigInterface
     */
    private $form;

    /**
     * ProductManager constructor.
     *
     * @param EntityManager $entityManager
     * @param FormFactoryInterface $formFactory
     * @param ContainerInterface $container
     * @param RequestStack $request
     */
    public function __construct(EntityManager $entityManager, FormFactoryInterface $formFactory, ContainerInterface $container, RequestStack $request) {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->container = $container;
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm()
    {
        return $this->formFactory->createNamed(new Customer(), CustomerType::class);
    }

    /**
     * @return bool
     */
    public function createCustomer()
    {
        $customer = new Customer();
        $customerPhoto = new CustomerPhoto();

        $this->form = $this->formFactory->createNamed('customer', CustomerType::class);
        $this->form->handleRequest($this->request->getMasterRequest());

        if($this->form->isSubmitted() && $this->form->isValid()) {

            $file = $customer->getPhoto();
            $fileName = null;

            if( isset($this->request->getMasterRequest()->files->get('customer')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->container->getParameter('upload_directory'), $fileName);
            }

            $customerPhoto->setThumbnailPhotoFileName($fileName);
            $customer->setPhoto($customerPhoto);

            $this->persist($this->form->getData());

            return true;

        }else {

            return false;

        }
    }

    public function updateCustomer($id)
    {
        $customerPhoto = new CustomerPhoto();

        $customer = $this->em->getRepository('AppBundle:Customer')->find($id);
        $this->form = $this->formFactory->createNamed('customer', CustomerType::class);
        $this->form->handleRequest($this->request->getMasterRequest());

        if( $this->form->isSubmitted() && $this->form->isValid() ) {

            $file = $customer->getPhoto();
            $fileName = null;

            if( isset($this->request->getMasterRequest()->files->get('customer')['photo']) ) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->container->getParameter('upload_directory'), $fileName);
            }

            $customerPhoto->setThumbnailPhotoFileName($fileName);
            $customer->setPhoto($customerPhoto);

            $this->persist($this->form->getData());

            return true;

        }else {

            return false;
        }
    }

    /**
     * @param $id
     * @return null|object
     */
    public function findOne($id) {
        return $this->em->getRepository('AppBundle:Customer')->findOneBy(['id' => $id]);
    }

    /**
     * @return array
     */
    public function findCustomers()
    {
        return $this->em->getRepository('AppBundle:Customer')->findBy([], ['id' => 'DESC']);
    }

    /**
     * @return FormConfigInterface
     */
    public function getForm() {
        return $this->form;
    }

    public function persist($data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {

        $customer = $this->em->getRepository('AppBundle:Customer')->find($id);

        if( !$customer )
            throw new Exception('This customer is does\'nt eextsis');

        $this->em->remove($customer);
        $this->em->flush();

        return true;
    }



}