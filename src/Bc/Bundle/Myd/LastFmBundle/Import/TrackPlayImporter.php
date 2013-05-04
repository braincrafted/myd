<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Bc\Bundle\LastFmBundle\Client;

use Bc\Bundle\Myd\MusicBundle\Entity\Track;
use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager;
use Bc\Bundle\Myd\MusicBundle\Model\UserInterface;

class TrackPlayImporter implements ImporterInterface
{
    /** @var Client */
    private $client;

    /** @var ImportFactory */
    private $factory;

    /** @var TrackPlayManager */
    private $trackPlayManager;

    /** @var array */
    private $albumCache = array();

    /** @var array */
    private $trackCache = array();

    public function __construct(Client $client, TrackPlayManager $trackPlayManager)
    {
        $this->client               = $client;
        $this->trackPlayManager     = $trackPlayManager;
    }

    public function setFactory(ImportFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    public function import(array $parameters)
    {
        if (!isset($parameters['user'])) {
            throw new \InvalidArgumentException('The parameter "user" must be set.');
        }

        // Import user (or retrieve User object from database if it does not exist)
        $user = $this->factory->getUserImporter()->import($parameters['user']);

        $command = $this->client->getCommand('user.getRecentTracks', array(
            'user'      => $parameters['user'],
            'page'      => isset($parameters['page']) ? $parameters['page'] : 1,
            'format'    => 'json'
        ));
        $response = $this->client->execute($command);

        foreach ($response['recenttracks']['track'] as $trackPlayData) {
            $artist = $this->factory->getArtistImporter()->import($trackPlayData['artist']);
            $album  = $this->factory->getAlbumImporter()->import($trackPlayData['album'], $artist);
            $track  = $this->factory->getTrackImporter()->import($trackPlayData, $album, $artist);
            $this->importTrackPlay($trackPlayData, $track, $user);
        }

        $this->factory->getArtistImporter()->flush();
        $this->factory->getAlbumImporter()->flush();
        $this->factory->getTrackImporter()->flush();
        $this->trackPlayManager->flush();
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
