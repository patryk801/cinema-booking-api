<?php

namespace AppBundle\Resource\Filtering\Reservation;


use AppBundle\Repository\ReservationRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class ReservationResourceFilter implements ResourceFilterInterface
{
    private $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('reservation');

        return $qb;
    }

    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(reservation)');

        return $qb;
    }

    private function getQuery(ReservationFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('reservation');

        if(!is_null($filter->getName()))
        {
            $qb->where($qb->expr()->like('reservation.name', ':name'));
            $qb->setParameter('name', "%{$filter->getName()}%");
        }

        if(!is_null($filter->getSurname()))
        {
            $qb->where($qb->expr()->like('reservation.surname', ':surname'));
            $qb->setParameter('surname', "%{$filter->getSurname()}%");
        }

        if(!is_null($filter->getEmail()))
        {
            $qb->where($qb->expr()->eq('reservation.email', ':email'));
            $qb->setParameter('email', $filter->getEmail());
        }

        if(!is_null($filter->getCreatedAt()))
        {
            $qb->where($qb->expr()->eq('reservation.createdAt', ':createdAt'));
            $qb->setParameter('createdAt', $filter->getCreatedAt());
        }

        if(!is_null($filter->getSortByArray()))
        {
            foreach ($filter->getSortByArray() as $by => $order)
            {
                $expr = 'desc' == $order ? $qb->expr()->desc("reservation.$by") : $qb->expr()->asc("reservation.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}