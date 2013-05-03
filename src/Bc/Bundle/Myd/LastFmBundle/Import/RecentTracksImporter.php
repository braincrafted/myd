<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\LastFmBundle\Client;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;
use Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Album;
use Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager;
use Bc\Bundle\Myd\MusicBundle\Entity\TrackManager;

class RecentTracksImporter
{
    /** @var Client */
    private $client;

    /** @var ArtistManager */
    private $artistManager;

    /** @var AlbumManager */
    private $albumManager;

    /** @var TrackManager */
    private $trackManager;

    /** @var array */
    private $artistCreatedCache = array();

    /** @var array */
    private $albumCreatedCache = array();

    /** @var array */
    private $trackCache = array();

    public function __construct(Client $client, ArtistManager $artistManager, AlbumManager $albumManager, TrackManager $trackManager)
    {
        $this->client           = $client;
        $this->artistManager    = $artistManager;
        $this->albumManager     = $albumManager;
        $this->trackManager     = $trackManager;
    }

    public function import(array $parameters)
    {
        if (!isset($parameters['user'])) {
            throw new \InvalidArgumentException('The parameter "user" must be set.');
        }

        $command = $this->client->getCommand('user.getRecentTracks', array(
            'user'      => $parameters['user'],
            'page'      => isset($parameters['page']) ? $parameters['page'] : 1,
            'format'    => 'json'
        ));
        $response = $this->client->execute($command);

        foreach ($response['recenttracks']['track'] as $trackPlayData) {
            $artist = $this->importArtist($trackPlayData['artist']);
            $album  = $this->importAlbum($trackPlayData['album'], $artist);
            $this->importTrack($trackPlayData, $album, $artist);
        }

        $this->artistManager->flush();
        $this->albumManager->flush();
        $this->trackManager->flush();
    }

    protected function importArtist(array $rawData)
    {
        $data = array(
            'name'  => $rawData['#text'],
            'mbId'  => $rawData['mbid']
        );

        $artist = null;

        if (isset($this->artistCreatedCache[$data['mbId']])) {
            $artist = $this->artistCreatedCache[$data['mbId']];
        }

        if (!$artist) {
            $artist = $this->artistManager->findArtistByMbId($data['mbId']);
        }

        if (!$artist) {
            $artist = $this->artistManager->createArtist($data);
            $this->artistManager->updateArtist($artist, false);
        }

        $this->artistCreatedCache[$artist->getMbId()] = $artist;

        return $artist;
    }

    protected function importAlbum(array $rawData, Artist $artist)
    {
        $data = array(
            'name' => $rawData['#text'],
            'mbId' => $rawData['mbid']
        );

        $album = null;

        if (isset($this->albumCreatedCache[$data['mbId']])) {
            $album = $this->albumCreatedCache[$data['mbId']];
        }

        if (!$album) {
            $album = $this->albumManager->findAlbumByMbId($data['mbId']);
        }

        if (!$album) {
            $album = $this->albumManager->createAlbum($data);
            $album->setArtist($artist);
            $this->albumManager->updateAlbum($album, false);
        }

        $this->albumCreatedCache[$album->getMbId()] = $album;

        return $album;
    }

    protected function importTrack(array $rawData, Album $album, Artist $artist)
    {
        $data = array(
            'name'  => $rawData['name'],
            'mbId'  => $rawData['mbid']
        );

        $track = null;

        if (isset($this->trackCache[$data['mbId']])) {
            $track = $this->trackCache[$data['mbId']];
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

        $this->trackCache[$track->getMbId()] = $track;
    }
}
