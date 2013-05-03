<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class ArtistManager
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

    public function createArtist(array $data = array())
    {
        $class = $this->class;
        $artist = new $class();

        if (isset($data['name'])) {
            $artist->setName($data['name']);
        }

        if (isset($data['mbId'])) {
            $artist->setMbId($data['mbId']);
        }

        return $artist;
    }

    public function findArtists()
    {
        return $this->repository->findAll();
    }

    public function findArtistByMbId($mbId)
    {
        return $this->repository->findOneBy(array('mbId' => $mbId));
    }

    public function updateArtist(Artist $artist, $andFlush = true)
    {
        $artist->setUpdatedAt(new \DateTime());
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
