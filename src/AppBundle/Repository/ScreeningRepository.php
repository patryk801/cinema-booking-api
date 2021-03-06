<?php

namespace AppBundle\Repository;

/**
 * ScreeningRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScreeningRepository extends \Doctrine\ORM\EntityRepository
{
    public function count($criteria = []): int
    {
        $qb = $this->createQueryBuilder('s');

        return $qb->select('count(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
