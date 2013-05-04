<?php

namespace Bc\Bundle\Myd\MusicBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;

interface UserManagerInterface
{
    public function createUser(array $data = array());

    public function findUsers();

    public function findUserByUsername($username);

    public function updateUser(UserInterface $user, $andFlush = true);

    public function flush();
}
