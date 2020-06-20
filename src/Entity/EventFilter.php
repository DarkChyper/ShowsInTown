<?php


namespace App\Entity;

use DateTime;

/**
 * Class EventFilter NOT AN ENTITY
 * @package App\Entity
 */
class EventFilter
{
    /**
     * @var DateTime
     */
    protected $fromDate;

    /**
     * @var DateTime
     */
    protected $toDate;

    /**
     * @var City
     */
    protected $city;


    /**
     * @var string
     */
    protected $artist;

    /**
     * EventFilter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return DateTime
     */
    public function getFromDate(): ?DateTime
    {
        return $this->fromDate;
    }

    /**
     * @param DateTime $fromDate
     */
    public function setFromDate(?DateTime $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return DateTime
     */
    public function getToDate(): ?DateTime
    {
        return $this->toDate;
    }

    /**
     * @param DateTime $toDate
     */
    public function setToDate(?DateTime $toDate): void
    {
        $this->toDate = $toDate;
    }

    /**
     * @return City
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }



    /**
     * @return string
     */
    public function getArtist(): ?string
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     */
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }

    /**
     * Return true if all fields are null or empty
     * @return bool
     */
    public function isEmpty()
    {
        $retour = false;
        if($this->fromDate === null &&
            $this->toDate === null &&
            $this->city === null &&
            ($this->artist === null || trim($this->artist) === '')
        ){
            $retour = true;
        }

        return $retour;
    }


}