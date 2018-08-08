<?php

namespace AppBundle\Resource\Filtering\Screening;

class ScreeningFilterDefinition
{
    private $startTime;
    private $endTime;
    private $timeFrom;
    private $timeTo;
    private $sortByArray;

    public function __construct(?\DateTime $startTime, ?\DateTime $endTime, ?\DateTime $timeFrom, ?\DateTime $timeTo, ?array $sortByArray)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->timeFrom = $timeFrom;
        $this->timeTo = $timeTo;
        $this->sortByArray = $sortByArray;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    public function getTimeFrom(): ?\DateTime
    {
        return $this->timeFrom;
    }

    public function getTimeTo(): ?\DateTime
    {
        return $this->timeTo;
    }

    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }
}