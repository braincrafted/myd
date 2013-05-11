<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;
use Bc\Bundle\Myd\MusicBundle\Entity\Album;

class TrackImporter implements ImporterInterface
{
    /** @var array */
    private $cache;

    /** @var TrackManager */
    private $trackManager;

    public function __construct(TrackManager $trackManager)
    {
        $this->trackManager = $trackManager;
    }

    public function setFactory(ImportFactory $factory)
    {
    }

    public function import(array $rawData, Album $album, Artist $artist)
    {
        $data = array(
            'name'  => $rawData['name'],
            'mbid'  => $rawData['mbid']
        );

        $track = null;

        if (isset($this->cache[$data['mbid']])) {
            $track = $this->cache[$data['mbid']];
        }

        if (!$track && $data['mbid']) {
            $track = $this->trackManager->findTrackByMbid($data['mbid']);
        }

        if (!$track && !$data['mbid']) {
            $track = $this->trackManager->findTrackByAlbumAndName($album, $data['name']);
        }

        if (!$track) {
            $track = $this->trackManager->createTrack($data);
            $track->setArtist($artist);
            $track->setAlbum($album);
            $this->trackManager->updateTrack($track, false);
        }

        $this->cache[$track->getMbid()] = $track;

        return $track;
    }

    public function flush()
    {
        $this->trackManager->flush();
        $this->cache = array();
    }
}
