<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager;

class ArtistImporter implements ImporterInterface
{
    /** @var array */
    private $cache;

    /** @var ArtistManager */
    private $artistManager;

    public function __construct(ArtistManager $artistManager)
    {
        $this->artistManager = $artistManager;
    }

    public function setFactory(ImportFactory $factory)
    {
    }

    public function import(array $rawData)
    {
        $data = array(
            'name'  => trim($rawData['#text']),
            'mbid'  => trim($rawData['mbid'])
        );

        $artist = null;

        if (!$artist && $data['mbid']) {
            $artist = $this->artistManager->findArtistByMbid($data['mbid']);
        }

        if (!$artist && !$data['mbid']) {
            $artist = $this->artistManager->findArtistByName($data['name']);
        }

        if (!$artist && ($data['mbid'] || $data['name'])) {
            $artist = $this->artistManager->createArtist($data);
            $this->artistManager->updateArtist($artist);
        }

        return $artist;
    }
}
