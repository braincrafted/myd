<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_track_play")
 */
class TrackPlay
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Track
     * @ORM\ManyToOne(targetEntity="Track", inversedBy="plays")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     */
    private $track;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="User", inversedBy="plays")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     * @ORM\Column(name="play_date", type="datetime")
     */
    private $playDate;

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
    }

    /**
     * Sets the ID.
     *
     * @param integer $id The ID
     *
     * @return TrackPlay
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
     * Sets the track.
     *
     * @param Track $track The track
     *
     * @return TrackPlay
     */
    public function setTrack(Track $track)
    {
        $this->track = $track;
        return $this;
    }

    /**
     * Returns the track.
     *
     * @return Track The track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Sets the user.
     *
     * @param UserInterface $user The user
     *
     * @return TrackPlay
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Returns the user.
     *
     * @return User the user
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setPlayDate(\DateTime $playDate)
    {
        $this->playDate = $playDate;

        return $this;
    }

    public function getPlayDate()
    {
        return $this->playDate;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
