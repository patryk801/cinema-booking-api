<?php

namespace AppBundle\Resource\Filtering\Screening;

use AppBundle\Repository\ScreeningRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class ScreeningResourceFilter implements ResourceFilterInterface
{
    private $repository;

    public function __construct(ScreeningRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('screening');

        return $qb;
    }

    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(screening)');

        return $qb;
    }

    private function getQuery(ScreeningFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('screening');

        if(!is_null($filter->getStartTime()))
        {
            $qb->where($qb->expr()->eq('screening.startTime', ':startTime'));
            $qb->setParameter('startTime', $filter->getStartTime());
        }

        if(!is_null($filter->getEndTime()))
        {
            $qb->where($qb->expr()->eq('screening.endTime', ':endTime'));
            $qb->setParameter('endTime', $filter->getEndTime());
        }

        if(!is_null($filter->getTimeFrom()))
        {
            $qb->where($qb->expr()->gte('screening.startTime', ':timeFrom'));
            $qb->setParameter('timeFrom', $filter->getTimeFrom());
        }

        if(!is_null($filter->getTimeTo()))
        {
            $qb->where($qb->expr()->lte('screening.endTime', ':timeTo'));
            $qb->setParameter('timeTo', $filter->getTimeTo());
        }

        if(!is_null($filter->getSortByArray()))
        {
            foreach ($filter->getSortByArray() as $by => $order)
            {
                $expr = 'desc' == $order ? $qb->expr()->desc("screening.$by") : $qb->expr()->asc("screening.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}