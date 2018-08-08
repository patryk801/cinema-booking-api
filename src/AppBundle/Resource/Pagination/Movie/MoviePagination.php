<?php

namespace AppBundle\Resource\Pagination\Movie;


use AppBundle\Resource\Filtering\Movie\MovieFilterDefinition;
use AppBundle\Resource\Filtering\Movie\MovieResourceFilter;
use AppBundle\Resource\Pagination\Page;
use Doctrine\ORM\UnexpectedResultException;

class MoviePagination
{
    private const RESOURCE_NAME = 'movies';
    private $resourceFilter;

    public function __construct(MovieResourceFilter $resourceFilter)
    {
        $this->resourceFilter = $resourceFilter;
    }

    public function paginate(Page $page, MovieFilterDefinition $filter): array
    {
        $resources = $this->resourceFilter->getResources($filter)
            ->setFirstResult($page->getOffset())
            ->setMaxResults($page->getLimit())
            ->getQuery()
            ->getResult();

        $pages = null;

        try
        {
            $resourceCount = $this->resourceFilter->getResourceCount($filter)
                ->getQuery()
                ->getSingleScalarResult();

            $pages = ceil($resourceCount / $page->getLimit());
        }
        catch (UnexpectedResultException $e) {}

        return [
            'page' => $page->getPage(),
            'limit' => $page->getLimit(),
            'pageCount' => $pages,
            self::RESOURCE_NAME => $resources
        ];
    }
}