<?php

namespace Bc\Bundle\Myd\LastFmBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class LastFmUserManager
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

    public function createLastFmUser()
    {
        $class = $this->class;

        return new $class();
    }

    public function findLastFmUsers()
    {
        return $this->repository->findAll();
    }

    public function findLastFmUserByUsername($username)
    {
        return $this->repository->findOneBy(array('username' => $username));
    }

    public function updateLastFmUser(LastFmUser $artist, $andFlush = true)
    {
        $artist->setUpdatedAt(new \DateTime(null, new \DateTimeZone('UTC')));
        $this->objectManager->persist($artist);

        if ($andFlush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
