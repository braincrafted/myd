<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class TrackPlayManager
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

    public function createTrackPlay(array $data = array())
    {
        $class = $this->class;
        $trackPlay = new $class();

        if (isset($data['playDate'])) {
            $trackPlay->setPlayDate($data['playDate']);
        }

        return $trackPlay;
    }

    public function findTrackPlays()
    {
        return $this->repository->findAll();
    }

    public function findTrackPlayByMbid($mbid)
    {
        return $this->repository->findOneBy(array('mbid' => $mbid));
    }

    public function updateTrackPlay(TrackPlay $trackPlay, $andFlush = true)
    {
        $trackPlay->setUpdatedAt(new \DateTime(null, new \DateTimeZone('UTC')));
        $this->objectManager->persist($trackPlay);

        if ($andFlush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
