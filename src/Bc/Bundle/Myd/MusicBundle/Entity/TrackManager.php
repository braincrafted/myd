<?php

namespace Bc\Bundle\Myd\MusicBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;

class TrackManager
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

    public function createTrack(array $data = array())
    {
        $class = $this->class;
        $track = new $class();

        if (isset($data['name'])) {
            $track->setName($data['name']);
        }

        if (isset($data['mbid'])) {
            $track->setMbid($data['mbid']);
        }

        if (isset($data['duration'])) {
            $track->setDuration($data['duration']);
        }

        return $track;
    }

    public function findTracks()
    {
        return $this->repository->findAll();
    }

    public function findTrackByMbid($mbid)
    {
        return $this->repository->findOneBy(array('mbid' => $mbid));
    }

    public function findTrackByAlbumAndName(Album $album, $name)
    {
        return $this->repository->findOneBy(array('album' => $album, 'name' => $name));
    }

    public function findTrackByArtistAndName(Artist $artist, $name)
    {
        return $this->repository->findOneBy(array('artist' => $artist, 'name' => $name));
    }

    public function updateTrack(Track $artist, $andFlush = true)
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
