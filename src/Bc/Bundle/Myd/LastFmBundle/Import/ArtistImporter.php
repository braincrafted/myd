<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager;

class ArtistImporter
{
    /** @var array */
    private $cache;

    /** @var ArtistManager */
    private $artistManager;

    public function __construct(ArtistManager $artistManager)
    {
        $this->artistManager = $artistManager;
    }

    public function import(array $rawData)
    {
        $data = array(
            'name'  => $rawData['#text'],
            'mbId'  => $rawData['mbid']
        );

        $artist = null;

        if (isset($this->cache[$data['mbId']])) {
            $artist = $this->cache[$data['mbId']];
        }

        if (!$artist) {
            $artist = $this->artistManager->findArtistByMbId($data['mbId']);
        }

        if (!$artist) {
            $artist = $this->artistManager->createArtist($data);
            $this->artistManager->updateArtist($artist, false);
        }

        $this->cache[$artist->getMbId()] = $artist;

        return $artist;
    }

    public function flush()
    {
        $this->artistManager->flush();
    }
}
