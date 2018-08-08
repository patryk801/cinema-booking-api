<?php

namespace AppBundle\Resource\Filtering\Reservation;


class ReservationFilterDefinition
{
    private $name;
    private $surname;
    private $email;
    private $createdAt;
    private $sortByArray;

    public function __construct(?string $name, ?string $surname, ?string $email, ?\DateTime $createdAt, ?array $sortByArray)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->sortByArray = $sortByArray;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }
}