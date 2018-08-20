<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Movie
 *
 * @ORM\Table(name="movies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie
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
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cast", type="string", length=255, nullable=true)
     *
     */
    private $cast;

    /**
     * @var string
     *
     * @ORM\Column(name="director", type="string", length=255, nullable=true)
     *
     */
    private $director;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="age_restrictions", type="string", length=255, nullable=true)
     *
     */
    private $ageRestrictions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="datetime")
     *
     * @Assert\NotBlank()
     *
     * @Serializer\Type("DateTime<'Y-m-d'>")
     */
    private $releaseDate;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     *
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="trailer_youtube_url", type="string", length=255, nullable=true)
     */
    private $trailerYoutubeUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="movies")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="Screening", mappedBy="movie")
     *
     * @Serializer\Exclude()
     */
    private $screenings;

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
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->screenings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add screening
     *
     * @param \AppBundle\Entity\Screening $screening
     *
     * @return Movie
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Movie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set genre
     *
     * @param \AppBundle\Entity\Genre $genre
     *
     * @return Movie
     */
    public function setGenre(\AppBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \AppBundle\Entity\Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set cast
     *
     * @param string $cast
     *
     * @return Movie
     */
    public function setCast($cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * Get cast
     *
     * @return string
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * Set director
     *
     * @param string $director
     *
     * @return Movie
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return string
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Movie
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set ageRestrictions
     *
     * @param string $ageRestrictions
     *
     * @return Movie
     */
    public function setAgeRestrictions($ageRestrictions)
    {
        $this->ageRestrictions = $ageRestrictions;

        return $this;
    }

    /**
     * Get ageRestrictions
     *
     * @return string
     */
    public function getAgeRestrictions()
    {
        return $this->ageRestrictions;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set trailerYoutubeUrl
     *
     * @param string $trailerYoutubeUrl
     *
     * @return Movie
     */
    public function setTrailerYoutubeUrl($trailerYoutubeUrl)
    {
        $this->trailerYoutubeUrl = $trailerYoutubeUrl;

        return $this;
    }

    /**
     * Get trailerYoutubeUrl
     *
     * @return string
     */
    public function getTrailerYoutubeUrl()
    {
        return $this->trailerYoutubeUrl;
    }

    /**
     * Set coverImage
     *
     * @param string $image
     *
     * @return Movie
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get coverImage
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
