<?php

namespace AppBundle\Repository;

/**
 * PurchaseOrderHeaderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseOrderHeaderRepository extends \Doctrine\ORM\EntityRepository
{

    public function getLastPurcharseOrderNumber()
    {
        return $this->createQueryBuilder('s')
            ->select('s.id','s.purchaseOrderNumber')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

}
