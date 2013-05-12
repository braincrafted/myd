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

    public function import(array $rawData, $album, Artist $artist)
    {
        $data = array(
            'name'  => $rawData['name'],
            'mbid'  => $rawData['mbid']
        );

        $track = null;

        if (!$track && $data['mbid']) {
            $track = $this->trackManager->findTrackByMbid($data['mbid']);
        }

        if (!$track && !$data['mbid'] && $album) {
            $track = $this->trackManager->findTrackByAlbumAndName($album, $data['name']);
        }

        if (!$track && !$data['mbid'] && !$album && $artist) {
            $track = $this->trackManager->findTrackByArtistAndName($artist, $data['name']);
        }

        if (!$track && ($artist || $album) && ($data['mbid'] || $data['name'])) {
            $track = $this->trackManager->createTrack($data);
            if ($artist) {
                $track->setArtist($artist);
            }
            if ($album) {
                $track->setAlbum($album);
            }
            $this->trackManager->updateTrack($track);
        }

        return $track;
    }
}
