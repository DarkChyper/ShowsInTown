<?php


namespace App\Service;


use App\Repository\ArtistRepository;


class ArtistService
{

    /**
     * @var ArtistRepository
     */
    protected $artistRepository;

    /**
     * EventFilterType constructor.
     * @param ArtistRepository $artistRepository
     */
    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    /**
     * @param string $name
     * @return int|mixed|string
     */
    public function autocompleteArtistName(string $name) {
        return $this->artistRepository->autoCompleteByName($name);
    }
}