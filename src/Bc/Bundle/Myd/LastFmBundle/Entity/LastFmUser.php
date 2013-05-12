<?php

namespace Bc\Bundle\Myd\LastFmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Bc\Bundle\Myd\MusicBundle\Entity\User as BaseUser;
use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay;

/**
 * @ORM\Entity
 */
class LastFmUser extends BaseUser
{
    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function __toString()
    {
        return sprintf('Last.fm user %s', $this->username);
    }
}
