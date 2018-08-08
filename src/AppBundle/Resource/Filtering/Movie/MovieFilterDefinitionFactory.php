<?php

namespace AppBundle\Resource\Filtering\Movie;


use Symfony\Component\HttpFoundation\Request;

class MovieFilterDefinitionFactory
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'title', 'description', 'cast', 'director', 'country', 'ageRestrictions', 'releaseDate'];

    public static function createFromRequest(Request $request): MovieFilterDefinition
    {
        return new MovieFilterDefinition(
            $request->get('title'),
            $request->get('description'),
            $request->get('cast'),
            $request->get('director'),
            $request->get('country'),
            $request->get('ageRestrictions'),
            $request->get('releaseDate'),
            $request->get('releaseDateFrom'),
            $request->get('releaseDateTo'),
            self::createSortByArray($request->get('sortBy'))
        );
    }

    private static function createSortByArray(?string $sortByString): ?array
    {
        if(is_null($sortByString)) return null;

        // Contains e.g. [0 => "column1 ASC", 1 => "column2 DESC"]
        $explodedByComma = explode(',', $sortByString);
        // Contains e.g. ["column1" => "ASC", "column2" => "DESC"]
        $reducedArray = array_reduce($explodedByComma, function ($carry, $item) {
            $explodedBySpace = explode(' ', preg_replace('/\s+/', ' ', $item));
            $sort = array_replace([1 => 'desc'], $explodedBySpace);
            $carry[$sort[0]] = $sort[1];

            return $carry;
        }, []);

        $arrayWithOnlyAllowedSortFields = array_intersect_key($reducedArray, array_flip(self::ACCEPTED_SORT_FIELDS));

        return $arrayWithOnlyAllowedSortFields;
    }
}