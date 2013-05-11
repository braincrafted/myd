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
            'name'  => $rawData['#text'],
            'mbid'  => $rawData['mbid']
        );

        $artist = null;

        if (isset($this->cache[$data['mbid']])) {
            $artist = $this->cache[$data['mbid']];
        }

        if (!$artist && $data['mbid']) {
            $artist = $this->artistManager->findArtistByMbid($data['mbid']);
        }

        if (!$artist && !$data['mbid']) {
            $artist = $this->artistManager->findArtistByName($data['name']);
        }

        if (!$artist) {
            $artist = $this->artistManager->createArtist($data);
            $this->artistManager->updateArtist($artist, false);
        }

        $this->cache[$artist->getMbid()] = $artist;

        return $artist;
    }

    public function flush()
    {
        $this->artistManager->flush();
        $this->cache = array();
    }
}
