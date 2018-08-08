<?php

namespace AppBundle\Resource\Pagination\Screening;

use AppBundle\Resource\Filtering\Screening\ScreeningFilterDefinition;
use AppBundle\Resource\Filtering\Screening\ScreeningResourceFilter;
use AppBundle\Resource\Pagination\Page;
use Doctrine\ORM\UnexpectedResultException;

class ScreeningPagination
{
    private const RESOURCE_NAME = 'screenings';
    private $resourceFilter;

    public function __construct(ScreeningResourceFilter $resourceFilter)
    {
        $this->resourceFilter = $resourceFilter;
    }

    public function paginate(Page $page, ScreeningFilterDefinition $filterDefinition): array
    {
        $resources = $this->resourceFilter->getResources($filterDefinition)
            ->setFirstResult($page->getOffset())
            ->setMaxResults($page->getLimit())
            ->getQuery()
            ->getResult();

        $pages = null;

        try
        {
            $resourceCount = $this->resourceFilter->getResourceCount($filterDefinition)
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