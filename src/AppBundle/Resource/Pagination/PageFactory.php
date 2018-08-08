<?php

namespace AppBundle\Resource\Pagination;


use Symfony\Component\HttpFoundation\Request;

class PageFactory
{
    private const KEY_LIMIT = 'limit';
    private const KEY_PAGE = 'page';
    private const DEFAULT_LIMIT = 5;
    private const DEFAULT_PAGE = 1;

    public static function createFromRequest(Request $request): Page
    {
        $page = $request->get(self::KEY_PAGE, self::DEFAULT_PAGE);
        $limit = $request->get(self::KEY_LIMIT, self::DEFAULT_LIMIT);

        return new Page($page, $limit);
    }
}