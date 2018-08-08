<?php

namespace AppBundle\Resource\Pagination\Reservation;

use AppBundle\Resource\Filtering\Reservation\ReservationFilterDefinition;
use AppBundle\Resource\Filtering\Reservation\ReservationResourceFilter;
use AppBundle\Resource\Pagination\Page;
use Doctrine\ORM\UnexpectedResultException;

class ReservationPagination
{
    private const RESOURCE_NAME = 'reservations';
    private $resourceFilter;

    public function __construct(ReservationResourceFilter $resourceFilter)
    {
        $this->resourceFilter = $resourceFilter;
    }

    public function paginate(Page $page, ReservationFilterDefinition $filterDefinition): array
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