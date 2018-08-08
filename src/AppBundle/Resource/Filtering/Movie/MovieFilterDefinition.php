<?php

namespace AppBundle\Resource\Filtering\Movie;


class MovieFilterDefinition
{
    private $title;
    private $description;
    private $cast;
    private $director;
    private $country;
    private $ageRestrictions;
    private $releaseDate;
    private $releaseDateFrom;
    private $releaseDateTo;
    private $sortByArray;

    public function __construct(?string $title,
                                ?string $description,
                                ?string $cast,
                                ?string $director,
                                ?string $country,
                                ?string $ageRestrictions,
                                ?string $releaseDate,
                                ?string $releaseDateFrom,
                                ?string $releaseDateTo,
                                ?array $sortByArray)
    {
        $this->title = $title;
        $this->description = $description;
        $this->cast = $cast;
        $this->director = $director;
        $this->country = $country;
        $this->ageRestrictions = $ageRestrictions;
        $this->releaseDate = $releaseDate;
        $this->releaseDateFrom = $releaseDateFrom;
        $this->releaseDateTo = $releaseDateTo;
        $this->sortByArray = $sortByArray;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCast(): ?string
    {
        return $this->cast;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getAgeRestrictions(): ?string
    {
        return $this->ageRestrictions;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function getReleaseDateFrom(): ?string
    {
        return $this->releaseDateFrom;
    }

    public function getReleaseDateTo(): ?string
    {
        return $this->releaseDateTo;
    }

    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }
}