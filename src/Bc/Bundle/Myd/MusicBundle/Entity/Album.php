<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_album")
 */
class Album
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="mbid", type="string", length=36, unique=true)
     */
    private $mbId;

    /**
     * @var Artist
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="albums")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    private $artist;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Track", mappedBy="album")
     */
    private $tracks;

    /**
     * @var \DateTime
     * @ORM\Column(name="release_date", type="datetime")
     */
    private $releaseDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->tracks    = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     *
     * @return Album
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the ID.
     *
     * @return integer The ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name of the album.
     *
     * @param string $name The name of the album
     *
     * @return Album
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name of the album.
     *
     * @return string The name of the album
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the MBID of the album.
     *
     * @param string $mbId The MBID
     *
     * @return Album
     */
    public function setMbId($mbId)
    {
        $this->mbId = $mbId;

        return $this;
    }

    /**
     * Returns the MBID of the album.
     *
     * @return string The MBID
     */
    public function getMbId()
    {
        return $this->mbId;
    }

    /**
     * Sets the artist of the album.
     *
     * @param Artist $artist The artist
     *
     * @return Album
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Returns the artist of the album.
     *
     * @return Artist The artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Adds a track to the album.
     *
     * @param Track $track The track
     *
     * @return Album
     */
    public function addTrack(Track $track)
    {
        $this->tracks->add($track);

        return $this;
    }

    /**
     * Returns the tracks of the album.
     *
     * @return ArrayCollection The tracks of the album
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * Sets the release date of the album.
     *
     * @param \DateTime $releaseDate The release date
     *
     * @return Album
     */
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Returns the release date of the album.
     *
     * @return \DateTime The release date
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Sets the date the album was created at.
     *
     * @param \DateTime $createdAt The date the album was created at
     *
     * @return Album
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the date the album was created at.
     *
     * @return \DateTime The date the album was created at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date the album was updated at.
     *
     * @param \DateTime $updatedAt The date the album was updated at
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the date the album was updated at.
     *
     * @return \DateTime The date the album was updated at
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}