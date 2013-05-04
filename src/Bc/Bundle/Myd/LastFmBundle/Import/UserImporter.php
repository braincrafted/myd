<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Model\UserManagerInterface;

class UserImporter implements ImporterInterface
{
    /** @var array */
    private $cache;

    /** @var UserManagerInterface */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function setFactory(ImportFactory $factory)
    {
    }

    public function import($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            $user = $this->userManager->createUser(array('username' => $username));
            $this->userManager->updateUser($user);
        }

        return $user;
    }
}
