<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter;

/**
 * TrackImporterTest
 *
 * @group unit
 */
class TrackImporterTest extends \PHPUnit_Framework_TestCase
{
    /** @var TrackImporter */
    private $importer;

    /** @var TrackManager */
    private $trackManager;

    public function setUp()
    {
        $this->trackManager = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\TrackManager');

        $this->importer = new TrackImporter($this->trackManager);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see TrackImporter::import()}.
     *
     * The track is NOT IN the cache and NOT IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::import()
     */
    public function testImport_NoCache_NoDb()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');

        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $track
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->once()
            ->andReturn('ca4a7e9c');
        $track
            ->shouldReceive('setArtist')
            ->with($artist)
            ->once();
        $track
            ->shouldReceive('setAlbum')
            ->with($album)
            ->once();

        $this->trackManager
            ->shouldReceive('findTrackByMbId')
            ->with('ca4a7e9c')
            ->once()
            ->andReturn(null);

        $this->trackManager
            ->shouldReceive('createTrack')
            ->with(array('name' => 'Angels', 'mbId' => 'ca4a7e9c'))
            ->once()
            ->andReturn($track);
        $this->trackManager
            ->shouldReceive('updateTrack')
            ->with($track, false)
            ->once();

        $result = $this->importer->import(
            array(
                'name'     => 'Angels',
                'mbid'      => 'ca4a7e9c'
            ),
            $album,
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Track', $result);
    }

    /**
     * Tests {@see TrackImporter::import()}.
     *
     * The track is NOT IN the cache but IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::import()
     */
    public function testImport_NoCache_Db()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');

        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $track
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->once()
            ->andReturn('ca4a7e9c');
        $track
            ->shouldReceive('setArtist')
            ->never();
        $track
            ->shouldReceive('setAlbum')
            ->never();

        $this->trackManager
            ->shouldReceive('findTrackByMbId')
            ->with('ca4a7e9c')
            ->once()
            ->andReturn($track);

        $this->trackManager
            ->shouldReceive('createTrack')
            ->never();
        $this->trackManager
            ->shouldReceive('updateTrack')
            ->never();

        $result = $this->importer->import(
            array(
                'name'     => 'Angels',
                'mbid'     => 'ca4a7e9c'
            ),
            $album,
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Track', $result);
    }

    /**
     * Tests {@see TrackImporter::import()}.
     *
     * The track is IN the cache.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::import()
     */
    public function testImport_Cache()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');

        /** Add Track to cache */
        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $track
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->twice()
            ->andReturn('ca4a7e9c');
        $track
            ->shouldReceive('setArtist')
            ->never();
        $track
            ->shouldReceive('setAlbum')
            ->never();

        $this->trackManager
            ->shouldReceive('findTrackByMbId')
            ->with('ca4a7e9c')
            ->once()
            ->andReturn($track);

        $this->importer->import(
            array(
                'name'     => 'Angels',
                'mbid'      => 'ca4a7e9c'
            ),
            $album,
            $artist
        );

        $result = $this->importer->import(
            array(
                'name'     => 'Angels',
                'mbid'      => 'ca4a7e9c'
            ),
            $album,
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Track', $result);
    }

    /**
     * Tests {@see TrackImporter::flush()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter::flush()
     */
    public function testFlush()
    {
        $this->trackManager
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->importer->flush();
    }
}
