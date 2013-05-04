<?php

namespace Bc\Bundle\Myd\LastFmBundle\Import;

class ImportFactory
{
    /** @var array */
    private $importers;

    public function __construct(array $importers)
    {
        foreach ($importers as $importer) {
            if (!$importer instanceof ImporterInterface) {
                throw new \InvalidArgumentException('Importers must implement ImporterInterface.');
            }

            $importer->setFactory($this);
        }

        $this->importers = $importers;
    }

    public function getArtistImporter()
    {
        if (!isset($this->importers['artist'])) {
            throw new \InvalidArgumentException('There is no service to import artists.');
        }

        return $this->importers['artist'];
    }

    public function getAlbumImporter()
    {
        if (!isset($this->importers['album'])) {
            throw new \InvalidArgumentException('There is no service to import albums.');
        }

        return $this->importers['album'];
    }

    public function getTrackImporter()
    {
        if (!isset($this->importers['track'])) {
            throw new \InvalidArgumentException('There is no service to import tracks.');
        }

        return $this->importers['track'];
    }

    public function getTrackPlayImporter()
    {
        if (!isset($this->importers['track_play'])) {
            throw new \InvalidArgumentException('There is no service to import track plays.');
        }

        return $this->importers['track_play'];
    }

    public function getUserImporter()
    {
        if (!isset($this->importers['user'])) {
            throw new \InvalidArgumentException('There is no service to import users.');
        }

        return $this->importers['user'];
    }
}
