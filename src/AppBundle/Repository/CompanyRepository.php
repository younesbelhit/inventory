<?php

namespace AppBundle\Repository;

/**
 * CompanyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyRepository extends \Doctrine\ORM\EntityRepository
{

    public function getInfo() {
        return $this->createQueryBuilder('C')
                ->select('c')
                ->from('AppBundle:Company', 'c')
                ->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();
    }
}
