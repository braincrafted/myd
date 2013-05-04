<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter;

/**
 * AlbumImporterTest
 *
 * @group unit
 */
class AlbumImporterTest extends \PHPUnit_Framework_TestCase
{
    /** @var AlbumImporter */
    private $importer;

    /** @var AlbumManager */
    private $albumManager;

    public function setUp()
    {
        $this->albumManager = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager');

        $this->importer = new AlbumImporter($this->albumManager);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see AlbumImporter::import()}.
     *
     * The album is NOT IN the cache and NOT IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::import()
     */
    public function testImport_NoCache_NoDb()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');

        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $album
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->once()
            ->andReturn('aef44e12');
        $album
            ->shouldReceive('setArtist')
            ->with($artist)
            ->once();

        $this->albumManager
            ->shouldReceive('findAlbumByMbId')
            ->with('aef44e12')
            ->once()
            ->andReturn(null);

        $this->albumManager
            ->shouldReceive('createAlbum')
            ->with(array('name' => 'Coexist', 'mbId' => 'aef44e12'))
            ->once()
            ->andReturn($album);
        $this->albumManager
            ->shouldReceive('updateAlbum')
            ->with($album, false)
            ->once();

        $result = $this->importer->import(
            array(
                '#text'     => 'Coexist',
                'mbid'      => 'aef44e12'
            ),
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Album', $result);
    }

    /**
     * Tests {@see AlbumImporter::import()}.
     *
     * The album is NOT IN the cache but IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::import()
     */
    public function testImport_NoCache_Db()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');

        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $album
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->once()
            ->andReturn('aef44e12');
        $album
            ->shouldReceive('setArtist')
            ->never();

        $this->albumManager
            ->shouldReceive('findAlbumByMbId')
            ->with('aef44e12')
            ->once()
            ->andReturn($album);

        $this->albumManager
            ->shouldReceive('createAlbum')
            ->never();
        $this->albumManager
            ->shouldReceive('updateAlbum')
            ->never();

        $result = $this->importer->import(
            array(
                '#text'     => 'Coexist',
                'mbid'      => 'aef44e12'
            ),
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Album', $result);
    }

    /**
     * Tests {@see AlbumImporter::import()}.
     *
     * The album is IN the cache.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::import()
     */
    public function testImport_Cache()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');

        /** Add Album to cache */
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $album
            ->shouldReceive('getMbId')
            ->withNoArgs()
            ->twice()
            ->andReturn('aef44e12');
        $album
            ->shouldReceive('setArtist')
            ->never();

        $this->albumManager
            ->shouldReceive('findAlbumByMbId')
            ->with('aef44e12')
            ->once()
            ->andReturn($album);

        $this->importer->import(
            array(
                '#text'     => 'Coexist',
                'mbid'      => 'aef44e12'
            ),
            $artist
        );

        $result = $this->importer->import(
            array(
                '#text'     => 'Coexist',
                'mbid'      => 'aef44e12'
            ),
            $artist
        );

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Album', $result);
    }

    /**
     * Tests {@see AlbumImporter::flush()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter::flush()
     */
    public function testFlush()
    {
        $this->albumManager
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->importer->flush();
    }
}
