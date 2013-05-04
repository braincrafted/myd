<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;
use Bc\Bundle\Myd\MusicBundle\Entity\Album;

class TrackImporter
{
    /** @var array */
    private $cache;

    /** @var TrackManager */
    private $trackManager;

    public function __construct(TrackManager $trackManager)
    {
        $this->trackManager = $trackManager;
    }

    public function import(array $rawData, Album $album, Artist $artist)
    {
        $data = array(
            'name'  => $rawData['name'],
            'mbId'  => $rawData['mbid']
        );

        $track = null;

        if (isset($this->cache[$data['mbId']])) {
            $track = $this->cache[$data['mbId']];
        }

        if (!$track) {
            $track = $this->trackManager->findTrackByMbId($data['mbId']);
        }

        if (!$track) {
            $track = $this->trackManager->createTrack($data);
            $track->setArtist($artist);
            $track->setAlbum($album);
            $this->trackManager->updateTrack($track, false);
        }

        $this->cache[$track->getMbId()] = $track;

        return $track;
    }

    public function flush()
    {
        $this->trackManager->flush();
    }
}
