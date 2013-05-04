<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;
use Bc\Bundle\Myd\MusicBundle\Model\UserManagerInterface;

class UserManager implements UserManagerInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var string */
    private $class;

    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $objectManager->getRepository($class);

        $metadata    = $objectManager->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function createUser(array $data = array())
    {
        $class = $this->class;
        $user = new $class();

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        return $user;
    }

    public function findUsers()
    {
        return $this->repository->findAll();
    }

    public function findUserByUsername($username)
    {
        return $this->repository->findOneBy(array('username' => $username));
    }

    public function updateUser(UserInterface $user, $andFlush = true)
    {
        $user->setUpdatedAt(new \DateTime(null, new \DateTimeZone('UTC')));
        $this->objectManager->persist($user);

        if ($andFlush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
