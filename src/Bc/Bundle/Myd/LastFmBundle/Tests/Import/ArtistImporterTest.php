<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter;

/**
 * ArtistImporterTest
 *
 * @group unit
 */
class ArtistImporterTest extends \PHPUnit_Framework_TestCase
{
    /** @var ArtistImporter */
    private $importer;

    /** @var ArtistManager */
    private $artistManager;

    public function setUp()
    {
        $this->artistManager = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager');

        $this->importer = new ArtistImporter($this->artistManager);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see ArtistImporter::import()}.
     *
     * The artist is NOT IN the cache and NOT IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::import()
     */
    public function testImport_NoCache_NoDb()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $artist
            ->shouldReceive('getMbid')
            ->withNoArgs()
            ->once()
            ->andReturn('7cd2d860');

        $this->artistManager
            ->shouldReceive('findArtistByMbid')
            ->with('7cd2d860')
            ->once()
            ->andReturn(null);

        $this->artistManager
            ->shouldReceive('createArtist')
            ->with(array('name' => 'The Thermals', 'mbid' => '7cd2d860'))
            ->once()
            ->andReturn($artist);
        $this->artistManager
            ->shouldReceive('updateArtist')
            ->with($artist, false)
            ->once();

        $result = $this->importer->import(array(
            '#text'     => 'The Thermals',
            'mbid'      => '7cd2d860'
        ));

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Artist', $result);
    }

    /**
     * Tests {@see ArtistImporter::import()}.
     *
     * The artist is NOT IN the cache but IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::import()
     */
    public function testImport_NoCache_Db()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $artist
            ->shouldReceive('getMbid')
            ->withNoArgs()
            ->once()
            ->andReturn('7cd2d860');

        $this->artistManager
            ->shouldReceive('findArtistByMbid')
            ->with('7cd2d860')
            ->once()
            ->andReturn($artist);

        $this->artistManager
            ->shouldReceive('createArtist')
            ->never();
        $this->artistManager
            ->shouldReceive('updateArtist')
            ->never();

        $result = $this->importer->import(array(
            '#text'     => 'The Thermals',
            'mbid'      => '7cd2d860'
        ));

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Artist', $result);
    }

    /**
     * Tests {@see ArtistImporter::import()}.
     *
     * The artist is IN the cache.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::import()
     */
    public function testImport_Cache()
    {
        /** Add Artist to cache */
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $artist
            ->shouldReceive('getMbid')
            ->withNoArgs()
            ->twice()
            ->andReturn('7cd2d860');

        $this->artistManager
            ->shouldReceive('findArtistByMbid')
            ->with('7cd2d860')
            ->once()
            ->andReturn($artist);

        $this->importer->import(array(
            '#text'     => 'The Thermals',
            'mbid'      => '7cd2d860'
        ));

        $result = $this->importer->import(array(
            '#text'     => 'The Thermals',
            'mbid'      => '7cd2d860'
        ));

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Entity\Artist', $result);
    }

    /**
     * Tests {@see ArtistImporter::flush()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter::flush()
     */
    public function testFlush()
    {
        $this->artistManager
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->importer->flush();
    }
}
