<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Artist
 *
 * @ORM\Entity
 * @ORM\Table(name="music_artist")
 */
class Artist
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
     * @ORM\Column(name="mbid", type="string", length=36, nullable=true)
     */
    private $mbid;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Album", mappedBy="artist")
     */
    private $albums;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Track", mappedBy="artist")
     */
    private $tracks;

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
        $this->albums    = new ArrayCollection();
        $this->tracks    = new ArrayCollection();
    }

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     *
     * @return Artist
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
     * @param string $name The name of the artist
     *
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string The name of the artist
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the MBID.
     *
     * @param string $mbid The MBID
     *
     * @return Artist
     */
    public function setMbid($mbid)
    {
        $this->mbid = $mbid;

        return $this;
    }

    /**
     * Returns the MBID.
     *
     * @return string The MBID
     */
    public function getMbid()
    {
        return $this->mbid;
    }

    /**
     * Adds an album to the artist.
     *
     * @param Album $album The album
     *
     * @return Artist
     */
    public function addAlbum(Album $album)
    {
        $this->albums->add($album);

        return $this;
    }

    /**
     * Returns the albums of the artist.
     *
     * @return ArrayCollection The albums of the artist
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * Adds a track to the artist.
     *
     * @param Track $track The track
     *
     * @return Artist
     */
    public function addTrack(Track $track)
    {
        $this->tracks->add($track);

        return $this;
    }

    /**
     * Returns the tracks of the artist.
     *
     * @return ArrayCollection The tracks of the artist
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * Sets the created at date.
     *
     * @param \DateTime $createdAt The date the artist was created
     *
     * @return Artist
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns the date the artist was created.
     *
     * @return \DateTime The date the artist was created
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date the artist was updated at.
     *
     * @param \DateTime $updatedAt The date the artist was updated
     *
     * @return Artist
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the date the artist was updated at.
     *
     * @return \DateTime The date the artist was updated at
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}