<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="duration", type="integer", nullable=true)
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="TrackPlay", mappedBy="track")
     */
    private $plays;

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

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->plays     = new ArrayCollection();
    }

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     *
     * @return Track
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
     * Sets the name.
     *
     * @param string $name The name of the track
     *
     * @return Track
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string The name of the track
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the MBID.
     *
     * @param string $mbId The MBID
     *
     * @return Track
     */
    public function setMbId($mbId)
    {
        $this->mbId = $mbId;

        return $this;
    }

    /**
     * Returns the MBID.
     *
     * @return string The MBID
     */
    public function getMbId()
    {
        return $this->mbId;
    }

    /**
     * Sets the duration of the track.
     *
     * @param integer $duration The duration of track
     *
     * @return Track
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Returns the duration of track.
     *
     * @return integer The duration of the track
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Sets the artist of the track.
     *
     * @param Artist $artist The artist of the track.
     *
     * @return Track
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Returns the artist of the track.
     *
     * @return Artist The artist of the track
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Sets the album of the track.
     * #
     * @param Album $album The track of the album
     *
     * @return Track
     */
    public function setAlbum(Album $album)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Returns the album of the track.
     *
     * @return Album The album of the track
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Adds the track play.
     *
     * @param TrackPlay $play The played track
     *
     * @return Track
     */
    public function addPlay(TrackPlay $play)
    {
        $this->plays->add($play);

        return $this;
    }

    /**
     * Returns the plays.
     *
     * @return TrackPlay Returns the plays
     */
    public function getPlays()
    {
        return $this->plays;
    }

    /**
     * Sets the date the track was created at.
     *
     * @param \DateTime $createdAt The date the track was created at
     *
     * @return Track
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the date the track was created at.
     *
     * @return \DateTime The date the track was created at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date the track was updated at.
     *
     * @param \DateTime $updatedAt The date the track was updated at
     *
     * @return Track
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the date the track was updated at.
     *
     * @return \DateTime The date the track was updated at
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
