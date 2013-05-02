<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_track")
 */
class Track
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
     * @var integer
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var Artist
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="tracks")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    private $artist;

    /**
     * @var Album
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="tracks")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private $album;

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
        $this->createdAt = new \DateTime();
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setMbId($mbId)
    {
        $this->mbId = $mbId;

        return $this;
    }

    public function getMbId()
    {
        return $this->mbId;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setAlbum(Album $album)
    {
        $this->album = $album;

        return $this;
    }

    public function getAlbum()
    {
        return $this->album;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}