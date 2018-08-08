<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Auditorium
 *
 * @ORM\Table(name="auditoriums")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuditoriumRepository")
 */
class Auditorium
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Seat", mappedBy="auditorium")
     *
     * @Serializer\Exclude()
     */
    private $seats;

    /**
     * @ORM\OneToMany(targetEntity="Screening", mappedBy="auditorium")
     *
     * @Serializer\Exclude()
     */
    private $screenings;

    public function __construct()
    {
        $this->seats = new ArrayCollection();
        $this->screenings = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Auditorium
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add seat
     *
     * @param \AppBundle\Entity\Seat $seat
     *
     * @return Auditorium
     */
    public function addSeat(\AppBundle\Entity\Seat $seat)
    {
        $this->seats[] = $seat;

        return $this;
    }

    /**
     * Remove seat
     *
     * @param \AppBundle\Entity\Seat $seat
     */
    public function removeSeat(\AppBundle\Entity\Seat $seat)
    {
        $this->seats->removeElement($seat);
    }

    /**
     * Get seats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Add screening
     *
     * @param \AppBundle\Entity\Screening $screening
     *
     * @return Auditorium
     */
    public function addScreening(\AppBundle\Entity\Screening $screening)
    {
        $this->screenings[] = $screening;

        return $this;
    }

    /**
     * Remove screening
     *
     * @param \AppBundle\Entity\Screening $screening
     */
    public function removeScreening(\AppBundle\Entity\Screening $screening)
    {
        $this->screenings->removeElement($screening);
    }

    /**
     * Get screenings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScreenings()
    {
        return $this->screenings;
    }
}
