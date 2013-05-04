<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory;

/**
 * ImportFactoryTest
 *
 * @group unit
 */
class ImportFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ImportFactory */
    private $factory;

    /** @var ContainerInterface */
    private $container;

    public function setUp()
    {
        $this->container = m::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->factory = new ImportFactory(array(
            'artist_importer'       => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockArtistImporter',
            'album_importer'        => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockAlbumImporter',
            'track_importer'        => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockTrackImporter',
            'track_play_importer'   => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockTrackPlayImporter',
            'user_importer'         => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockUserImporter'
        ));
        $this->factory->setContainer($this->container);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see ImportFactory::getArtistImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getArtistImporter()
     */
    public function testGetArtistImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_music.artist_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getArtistImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockArtistImporter', $importer);
        $this->assertSame($importer, $this->factory->getArtistImporter());
    }

    /**
     * Tests {@see ImportFactory::getAlbumImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getAlbumImporter()
     */
    public function testGetAlbumImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_music.album_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getAlbumImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockAlbumImporter', $importer);
        $this->assertSame($importer, $this->factory->getAlbumImporter());
    }

    /**
     * Tests {@see ImportFactory::getTrackImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackImporter()
     */
    public function testGetTrackImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_music.track_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getTrackImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockTrackImporter', $importer);
        $this->assertSame($importer, $this->factory->getTrackImporter());
    }

    /**
     * Tests {@see ImportFactory::getTrackPlayImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackPlayImporter()
     */
    public function testGetTrackPlayImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_lastfm.client')
            ->once()
            ->andReturn(new \stdClass());

        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_lastfm.import.factory')
            ->once()
            ->andReturn(new \stdClass());

        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_music.track_play_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getTrackPlayImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockTrackPlayImporter', $importer);
        $this->assertSame($importer, $this->factory->getTrackPlayImporter());
    }

    /**
     * Tests {@see ImportFactory::getUserImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getUserImporter()
     */
    public function testGetUserImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_lastfm.user_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getUserImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockUserImporter', $importer);
        $this->assertSame($importer, $this->factory->getUserImporter());
    }
}

class MockArtistImporter
{
    public function __construct($am)
    {
    }
}

class MockAlbumImporter
{
    public function __construct($am)
    {
    }
}

class MockTrackImporter
{
    public function __construct($tm)
    {
    }
}

class MockTrackPlayImporter
{
    public function __construct($c, $f, $tpm)
    {
    }
}

class MockUserImporter
{
    public function __construct($um)
    {
    }
}
