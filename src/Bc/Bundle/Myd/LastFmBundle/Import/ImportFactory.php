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

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getArtistImporter()
    {
        if (!$this->artistImporter) {
            $this->artistImporter = new ArtistImporter($this->container->get('bc_myd_music.artist_manager'));
        }

        return $this->artistImporter;
    }
}
