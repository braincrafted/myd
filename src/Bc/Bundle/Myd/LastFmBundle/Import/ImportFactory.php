<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ImportFactory implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var ArtistImporter */
    private $artistImporter;

    /** @var AlbumImporter */
    private $albumImporter;

    /** @var TrackImporter */
    private $trackImporter;

    /** @var UserImporter */
    private $userImporter;

    /** @var array */
    private $classes;

    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getArtistImporter()
    {
        if (!$this->artistImporter) {
            $class = $this->classes['artist_importer'];
            $this->artistImporter = new $class($this->container->get('bc_myd_music.artist_manager'));
        }

        return $this->artistImporter;
    }

    public function getAlbumImporter()
    {
        if (!$this->albumImporter) {
            $class = $this->classes['album_importer'];
            $this->albumImporter = new $class($this->container->get('bc_myd_music.album_manager'));
        }

        return $this->albumImporter;
    }

    public function getTrackImporter()
    {
        if (!$this->trackImporter) {
            $class = $this->classes['track_importer'];
            $this->trackImporter = new $class($this->container->get('bc_myd_music.track_manager'));
        }

        return $this->trackImporter;
    }

    public function getUserImporter()
    {
        if (!$this->userImporter) {
            $class = $this->classes['user_importer'];
            $this->userImporter = new $class($this->container->get('bc_myd_lastfm.user_manager'));
        }

        return $this->userImporter;
    }
}
