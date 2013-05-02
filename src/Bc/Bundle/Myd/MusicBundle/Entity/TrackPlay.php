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
     * @ORM\ManyToOne(targetEntity="Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser", inversedBy="plays")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTrack(Track $track)
    {
        $this->track = $track;
        return $this;
    }

    public function getTrack()
    {
        return $this->track;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}
