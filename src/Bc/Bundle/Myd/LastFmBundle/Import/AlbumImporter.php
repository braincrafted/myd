<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;

class AlbumImporter
{
    /** @var array */
    private $cache;

    /** @var AlbumManager */
    private $albumManager;

    public function __construct(AlbumManager $albumManager)
    {
        $this->albumManager = $albumManager;
    }

    public function import(array $rawData, Artist $artist)
    {
        $data = array(
            'name' => $rawData['#text'],
            'mbId' => $rawData['mbid']
        );

        $album = null;

        if (isset($this->cache[$data['mbId']])) {
            $album = $this->cache[$data['mbId']];
        }

        if (!$album) {
            $album = $this->albumManager->findAlbumByMbId($data['mbId']);
        }

        if (!$album) {
            $album = $this->albumManager->createAlbum($data);
            $album->setArtist($artist);
            $this->albumManager->updateAlbum($album, false);
        }

        $this->cache[$album->getMbId()] = $album;

        return $album;
    }

    public function flush()
    {
        $this->albumManager->flush();
    }
}
