<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Event
 * @package App\Entity
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Assert\Date(message="event.date.date")
     *
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     * @Assert\Type(type={"App\Entity\Artist"}, message="event.artist.type")
     */
    protected $artist;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @Assert\Type(type={"App\Entity\City"}, message="event.artist.city")
     */
    protected $city;

    /**
     * @var int
     */
    protected $artistChoice;

    /**
     * @var int
     */
    protected $cityChoice;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->id = 0;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist): void
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getArtistChoice(): ?int
    {
        return $this->artistChoice;
    }

    /**
     * @param int $artistChoice
     */
    public function setArtistChoice(int $artistChoice): void
    {
        $this->artistChoice = $artistChoice;
    }

    /**
     * @return int
     */
    public function getCityChoice(): ?int
    {
        return $this->cityChoice;
    }

    /**
     * @param int $cityChoice
     */
    public function setCityChoice(int $cityChoice): void
    {
        $this->cityChoice = $cityChoice;
    }



    /**
     *
     */
    public function prepareToEdit(){
        if($this->city !== null){
            $this->setCityChoice($this->getCity()->getId());
            $this->city = null;
        }
        if($this->artist !== null){
            $this->setArtistChoice($this->getArtist()->getId());
            $this->artist = null;
        }

    }
}