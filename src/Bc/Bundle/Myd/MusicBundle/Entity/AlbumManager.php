<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class AlbumManager
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

    public function createAlbum(array $data = array())
    {
        $class = $this->class;
        $album = new $class();

        if (isset($data['name'])) {
            $album->setName($data['name']);
        }

        if (isset($data['mbId'])) {
            $album->setMbId($data['mbId']);
        }

        if (isset($data['releaseDate'])) {
            $album->setReleaseDate($data['releaseDate']);
        }

        return $album;
    }

    public function findAlbums()
    {
        return $this->repository->findAll();
    }

    public function findAlbumByMbId($mbId)
    {
        return $this->repository->findOneBy(array('mbId' => $mbId));
    }

    public function updateAlbum(Album $artist, $andFlush = true)
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
