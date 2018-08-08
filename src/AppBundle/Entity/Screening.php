<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Screening
 *
 * @ORM\Table(name="screenings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScreeningRepository")
 */
class Screening
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime")
     */
    private $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="screenings")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     *
     * @Serializer\Exclude()
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="Auditorium", inversedBy="screenings")
     * @ORM\JoinColumn(name="auditorium_id", referencedColumnName="id")
     *
     * @Serializer\Exclude()
     */
    private $auditorium;

    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="screening")
     *
     * @Serializer\Exclude()
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Screening
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Screening
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set movie
     *
     * @param \AppBundle\Entity\Movie $movie
     *
     * @return Screening
     */
    public function setMovie(\AppBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \AppBundle\Entity\Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Set auditorium
     *
     * @param \AppBundle\Entity\Auditorium $auditorium
     *
     * @return Screening
     */
    public function setAuditorium(\AppBundle\Entity\Auditorium $auditorium = null)
    {
        $this->auditorium = $auditorium;

        return $this;
    }

    /**
     * Get auditorium
     *
     * @return \AppBundle\Entity\Auditorium
     */
    public function getAuditorium()
    {
        return $this->auditorium;
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Screening
     */
    public function addReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
