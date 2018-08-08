<?php

namespace AppBundle\Resource\Filtering\Movie;


use AppBundle\Repository\MovieRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class MovieResourceFilter implements ResourceFilterInterface
{
    private $repository;

    public function __construct(MovieRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('movie');

        return $qb;
    }

    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(movie)');

        return $qb;
    }

    private function getQuery(MovieFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('movie');

        if(!is_null($filter->getTitle()))
        {
            $qb->where($qb->expr()->like('movie.title', ':title'));
            $qb->setParameter('title', "%{$filter->getTitle()}%");
        }

        if(!is_null($filter->getDescription()))
        {
            $qb->andWhere($qb->expr()->like('movie.description', ':description'));
            $qb->setParameter('description', "%{$filter->getDescription()}%");
        }

        if(!is_null($filter->getCast()))
        {
            $qb->andWhere($qb->expr()->like('movie.cast', ':cast'));
            $qb->setParameter('cast', "%{$filter->getCast()}%");
        }

        if(!is_null($filter->getDirector()))
        {
            $qb->andWhere($qb->expr()->like('movie.director', ':director'));
            $qb->setParameter('director', "%{$filter->getDirector()}%");
        }

        if(!is_null($filter->getCountry()))
        {
            $qb->andWhere($qb->expr()->like('movie.country', ':country'));
            $qb->setParameter('country', "%{$filter->getCountry()}%");
        }

        if(!is_null($filter->getAgeRestrictions()))
        {
            $qb->andWhere($qb->expr()->like('movie.ageRestrictions', ':ageRestrictions'));
            $qb->setParameter('ageRestrictions', "%{$filter->getAgeRestrictions()}%");
        }

        if(!is_null($filter->getReleaseDate()))
        {
            $qb->andWhere($qb->expr()->like('movie.releaseDate', ':releaseDate'));
            $qb->setParameter('releaseDate', "%{$filter->getReleaseDate()}%");
        }

        if(!is_null($filter->getReleaseDateFrom()))
        {
            $qb->andWhere($qb->expr()->gte('movie.releaseDate', ':releaseDate'));
            $qb->setParameter('releaseDate', $filter->getReleaseDateFrom());
        }

        if(!is_null($filter->getReleaseDateTo()))
        {
            $qb->andWhere($qb->expr()->lte('movie.releaseDate', ':releaseDate'));
            $qb->setParameter('releaseDate', $filter->getReleaseDateTo());
        }

        if(!is_null($filter->getSortByArray()))
        {
            foreach ($filter->getSortByArray() as $by => $order)
            {
                $expr = 'desc' == $order ? $qb->expr()->desc("movie.$by") : $qb->expr()->asc("movie.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}