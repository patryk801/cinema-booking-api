<?php

namespace AppBundle\Resource\Filtering\Reservation;


use Symfony\Component\HttpFoundation\Request;

class ReservationFilterDefinitionFactory
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'createdAt', 'name', 'surname', 'email'];

    public static function createFromRequest(Request $request): ReservationFilterDefinition
    {
        return new ReservationFilterDefinition(
            $request->get('name'),
            $request->get('surname'),
            $request->get('email'),
            self::convertStringToDateTime($request->get('createdAt')),
            self::createSortByArray($request->get('sortBy'))
        );
    }

    private static function convertStringToDateTime(?string $string): ?\DateTime
    {
        $dateTime = null;
        if(!is_null($string))
        {
            try { $dateTime = new \DateTime($string); }
            catch (\Exception $e) {}
        }

        return $dateTime;
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