<?php

namespace AppBundle\Resource\Pagination;


class Page
{
    private $page;
    private $limit;
    private $offset;

    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->offset = ($page - 1) * $limit;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return float|int
     */
    public function getOffset()
    {
        return $this->offset;
    }
}