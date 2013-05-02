<?php

namespace Bc\Bundle\Myd\MusicBundle\Model;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay;

interface UserInterface
{
    /**
     * Sets the ID of the user.
     *
     * @param integer $id The ID
     *
     * @return UserInterface
     */
    public function setId($id);

    /**
     * Returns the ID of the user.
     *
     * @return integer The ID
     */
    public function getId();

    /**
     * Sets the username.
     *
     * @param string $username The username
     *
     * @return UserInterface
     */
    public function setUsername($username);

    /**
     * Returns the username.
     *
     * @return string The username
     */
    public function getUsername();

    public function addPlay(TrackPlay $play);

    public function getPlays();

    /**
     * Sets the date the user was created at.
     *
     * @param \DateTime $createdAt The date the user was created at
     *
     * @return UserInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Returns the date the user was created at.
     *
     * @return \DateTime The date the user was created at
     */
    public function getCreatedAt();

    /**
     * Sets the date the user was updated at.
     *
     * @param \DateTime $updatedAt The date the user was updated at
     *
     * @return UserInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Returns the date the user was updated at.
     *
     * @return \DateTime The date the user was updated at
     */
    public function getUpdatedAt();
}
