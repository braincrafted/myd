<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;

class AlbumImporter implements ImporterInterface
{
    /** @var array */
    private $cache;

    /** @var AlbumManager */
    private $albumManager;

    public function __construct(AlbumManager $albumManager)
    {
        $this->albumManager = $albumManager;
    }

    public function setFactory(ImportFactory $factory)
    {
    }

    public function import(array $rawData, Artist $artist)
    {
        $data = array(
            'name' => trim($rawData['#text']),
            'mbid' => trim($rawData['mbid'])
        );

        $album = null;

        if (!$album && $data['mbid']) {
            $album = $this->albumManager->findAlbumByMbid($data['mbid']);
        }

        if (!$album && !$data['mbid']) {
            $album = $this->albumManager->findAlbumByArtistAndName($artist, $data['name']);
        }

        if (!$album && $artist && ($data['name'] || $data['mbid'])) {
            $album = $this->albumManager->createAlbum($data);
            $album->setArtist($artist);
            $this->albumManager->updateAlbum($album);
        }

        return $album;
    }
}
