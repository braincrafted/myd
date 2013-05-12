<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Doctrine\Common\Persistence\ObjectManager;
use Guzzle\Http\Exception\ServerErrorResponseException;

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

    /** @var ObjectManager */
    private $objectManager;

    /** @var callback */
    private $importCallback;

    public function __construct(Client $client, TrackPlayManager $trackPlayManager, ObjectManager $objectManager)
    {
        $this->client               = $client;
        $this->trackPlayManager     = $trackPlayManager;
        $this->objectManager = $objectManager;
    }

    public function setFactory(ImportFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    public function setImportCallback($importCallback)
    {
        $this->importCallback = $importCallback;
        return $this;
    }

    public function import(array $parameters, $limit = null)
    {
        if (!isset($parameters['user'])) {
            throw new \InvalidArgumentException('The parameter "user" must be set.');
        }

        // Start with page 1
        $parameters['page'] = 1;

        // Import user (or retrieve User object from database if it does not exist)
        $user = $this->factory->getUserImporter()->import($parameters['user']);

        $importCount = 0;

        do {
            $response = $this->fetchPage($parameters);
            $this->savePage($response['recenttracks']['track'], $user);

            $options = $response['recenttracks']['@attr'];
            if ($this->importCallback) {
                call_user_func($this->importCallback, '', $options);
            }

            // Wait a little bit before we import the next page.
            usleep(500000);

            // Increment page
            $parameters['page']++;
            $importCount += 200;

            if ($limit > 0 && $importCount >= $limit) {
                break;
            }
        } while ($options['page'] < $options['totalPages']);
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

    private function fetchPage(array $inputParameters)
    {
        $parameters = array(
            'user'      => $inputParameters['user'],
            'page'      => $inputParameters['page'],
            'limit'     => 200,
            'format'    => 'json'
        );
        if (isset($inputParameters['from']) && $inputParameters['from']) {
            $parameters['from'] = $inputParameters['from'];
        }
        if (isset($inputParameters['to']) && $inputParameters['to']) {
            $parameters['to'] = $inputParameters['to'];
        }

        $command = $this->client->getCommand('user.getRecentTracks', $parameters);
        $response = $this->executeFetchPage($command);

        if (!isset($response['recenttracks']['track'])) {
            throw new \RuntimeException(sprintf('Received invalid response from last.fm: %s', print_r($response, true)));
        }

        return $response;
    }

    private function executeFetchPage($command)
    {
        try {
            return $this->client->execute($command);
        } catch (ServerErrorResponseException $e) {
            sleep(10);
            return $this->executeFetchPage($command);
        }
    }

    private function savePage(array $rawTrackPlays, UserInterface $user)
    {
        foreach ($rawTrackPlays as $rawTrackPlay) {
            $artist = $this->factory->getArtistImporter()->import($rawTrackPlay['artist']);
            $album  = $this->factory->getAlbumImporter()->import($rawTrackPlay['album'], $artist);
            $track  = $this->factory->getTrackImporter()->import($rawTrackPlay, $album, $artist);
            if ($track) {
                $this->importTrackPlay($rawTrackPlay, $track, $user);
            }
        }

        $this->objectManager->flush();
        $this->objectManager->clear();
        gc_collect_cycles();
    }
}
