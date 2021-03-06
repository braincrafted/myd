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

        if (isset($data['mbid'])) {
            $artist->setMbid($data['mbid']);
        }

        return $artist;
    }

    public function findArtists()
    {
        return $this->repository->findAll();
    }

    public function findArtistByMbid($mbid)
    {
        return $this->repository->findOneBy(array('mbid' => $mbid));
    }

    public function findArtistByName($name)
    {
        return $this->repository->findOneBy(array('name' => $name));
    }

    public function updateArtist(Artist $artist, $andFlush = true)
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
