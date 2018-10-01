<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Reservation
 *
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Reservation
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
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Screening", inversedBy="reservations")
     * @ORM\JoinColumn(name="screening_id", referencedColumnName="id")
     *
     */
    private $screening;

    /**
     * Many Reservations have Many Seats.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Seat")
     * @ORM\JoinTable(name="reservations_seats",
     *      joinColumns={@ORM\JoinColumn(name="reservation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="seat_id", referencedColumnName="id")}
     *      )
     */
    private $seats;

    public function __construct()
    {
        $this->seats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Reservation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set screening
     *
     * @param \AppBundle\Entity\Screening $screening
     *
     * @return Reservation
     */
    public function setScreening(\AppBundle\Entity\Screening $screening = null)
    {
        $this->screening = $screening;

        return $this;
    }

    /**
     * Get screening
     *
     * @return \AppBundle\Entity\Screening
     */
    public function getScreening()
    {
        return $this->screening;
    }

    /**
     * @ORM\PreFlush()
     */
    public function onPreFlush()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Reservation
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
     * Set surname
     *
     * @param string $surname
     *
     * @return Reservation
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function addSeat(Seat $seat)
    {
        $this->seats[] = $seat;
    }
}
