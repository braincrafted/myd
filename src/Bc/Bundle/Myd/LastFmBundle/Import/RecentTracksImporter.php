<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\LastFmBundle\Client;
use Bc\Bundle\Myd\MusicBundle\Entity\Artist;
use Bc\Bundle\Myd\MusicBundle\Entity\Album;
use Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager;
use Bc\Bundle\Myd\MusicBundle\Entity\Track;
use Bc\Bundle\Myd\MusicBundle\Entity\TrackManager;
use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager;
use Bc\Bundle\Myd\MusicBundle\Model\UserManagerInterface;
use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;

class RecentTracksImporter
{
    /** @var Client */
    private $client;

    /** @var ImportFactory */
    private $factory;

    /** @var AlbumManager */
    private $albumManager;

    /** @var TrackManager */
    private $trackManager;

    /** @var TrackPlayManager */
    private $trackPlayManager;

    /** @var UserManagerInterface */
    private $userManager;

    /** @var array */
    private $albumCache = array();

    /** @var array */
    private $trackCache = array();

    public function __construct(Client $client, ImportFactory $factory, AlbumManager $albumManager, TrackManager $trackManager, TrackPlayManager $trackPlayManager, UserManagerInterface $userManager)
    {
        $this->client           = $client;
        $this->factory = $factory;
        $this->albumManager     = $albumManager;
        $this->trackManager     = $trackManager;
        $this->trackPlayManager = $trackPlayManager;
        $this->userManager      = $userManager;
    }

    public function import(array $parameters)
    {
        if (!isset($parameters['user'])) {
            throw new \InvalidArgumentException('The parameter "user" must be set.');
        }

        // Import user (or retrieve User object from database if it does not exist)
        $user = $this->importUser($parameters['user']);

        $command = $this->client->getCommand('user.getRecentTracks', array(
            'user'      => $parameters['user'],
            'page'      => isset($parameters['page']) ? $parameters['page'] : 1,
            'format'    => 'json'
        ));
        $response = $this->client->execute($command);

        foreach ($response['recenttracks']['track'] as $trackPlayData) {
            $artist = $this->factory->getArtistImporter()->import($trackPlayData['artist']);
            $album  = $this->importAlbum($trackPlayData['album'], $artist);
            $track  = $this->importTrack($trackPlayData, $album, $artist);
            $this->importTrackPlay($trackPlayData, $track, $user);
        }

        $this->factory->getArtistImporter()->flush();
        $this->albumManager->flush();
        $this->trackManager->flush();
        $this->trackPlayManager->flush();
    }

    protected function importUser($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            $user = $this->userManager->createUser(array('username' => $username));
            $this->userManager->updateUser($user);
        }

        return $user;
    }

    protected function importAlbum(array $rawData, Artist $artist)
    {
        $data = array(
            'name' => $rawData['#text'],
            'mbId' => $rawData['mbid']
        );

        $album = null;

        if (isset($this->albumCache[$data['mbId']])) {
            $album = $this->albumCache[$data['mbId']];
        }

        if (!$album) {
            $album = $this->albumManager->findAlbumByMbId($data['mbId']);
        }

        if (!$album) {
            $album = $this->albumManager->createAlbum($data);
            $album->setArtist($artist);
            $this->albumManager->updateAlbum($album, false);
        }

        $this->albumCache[$album->getMbId()] = $album;

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

        return $track;
    }

    protected function importTrackPlay(array $rawData, Track $track, UserInterface $user)
    {
        if (!isset($rawData['date'])) {
            return;
        }

        $data = array(
            'playDate'  => new \DateTime($rawData['date']['#text'], new \DateTimeZone('UTC'))
        );

        $trackPlay = $this->trackPlayManager->createTrackPlay($data);
        $trackPlay->setTrack($track);
        $trackPlay->setUser($user);

        $this->trackPlayManager->updateTrackPlay($trackPlay, false);
    }
}
