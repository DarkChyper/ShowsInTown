<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Artist
 * @package App\Entity
 *
 * @ORM\Table(name="artist")
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 *
 */
class Artist
{
    /**
     * @var string name of the artist
     * @ORM\Column(name="name", type="string", length=45, unique=true)
     * @Assert\Length(
     *     min        = 2,
     *     max        = 45,
     *     minMessage = "artist.name.length.min",
     *     maxMessage = "artist.name.length.max")
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /**
     * Artist constructor.
     */
    public function __construct()
    {
        $this->_id = 1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


}