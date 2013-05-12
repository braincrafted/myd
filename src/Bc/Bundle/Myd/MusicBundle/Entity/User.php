<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_user")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="account_type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lastfm" = "Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser"
 * })
 */
abstract class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay", mappedBy="user")
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
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->plays = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function addPlay(TrackPlay $play)
    {
        $this->plays->add($play);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPlays()
    {
        return $this->plays;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function __toString()
    {
        return sprintf('User %d', $this->id);
    }
}
