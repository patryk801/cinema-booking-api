<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Seat
 *
 * @ORM\Table(name="seats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeatRepository")
 */
class Seat
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
     * @ORM\Column(name="name", type="string", length=3)
     */
    private $name;

    /**
     * @ORM\Column(name="row", type="string", length=3)
     */
    private $row;

    /**
     * @ORM\ManyToOne(targetEntity="Auditorium", inversedBy="seats")
     * @ORM\JoinColumn(name="auditorium_id", referencedColumnName="id")
     *
     * @Serializer\Exclude()
     */
    private $auditorium;

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
     * @return Seat
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
     * Set auditorium
     *
     * @param \AppBundle\Entity\Auditorium $auditorium
     *
     * @return Seat
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
     * Set row
     *
     * @param string $row
     *
     * @return Seat
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get row
     *
     * @return string
     */
    public function getRow()
    {
        return $this->row;
    }
}
