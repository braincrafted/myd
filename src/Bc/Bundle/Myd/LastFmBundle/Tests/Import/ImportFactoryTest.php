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
        $artistImporter = m::mock('Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter');
        $artistImporter->shouldReceive('setFactory')->withAnyArgs()->once();

        $albumImporter = m::mock('Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter');
        $albumImporter->shouldReceive('setFactory')->withAnyArgs()->once();

        $trackImporter = m::mock('Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter');
        $trackImporter->shouldReceive('setFactory')->withAnyArgs()->once();

        $trackPlayImporter = m::mock('Bc\Bundle\Myd\LastFmBundle\Import\TrackPlayImporter');
        $trackPlayImporter->shouldReceive('setFactory')->withAnyArgs()->once();

        $userImporter = m::mock('Bc\Bundle\Myd\LastFmBundle\Import\UserImporter');
        $userImporter->shouldReceive('setFactory')->withAnyArgs()->once();

        $this->factory = new ImportFactory(array(
            'artist'       => $artistImporter,
            'album'        => $albumImporter,
            'track'        => $trackImporter,
            'track_play'   => $trackPlayImporter,
            'user'         => $userImporter
        ));
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see ImportFactory::getArtistImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getArtistImporter()
     */
    public function testGetArtistImporter()
    {
        $this->assertInstanceOf(
            'Bc\Bundle\Myd\LastFmBundle\Import\ArtistImporter',
            $this->factory->getArtistImporter()
        );
    }

    /**
     * Tests {@see ImportFactory::getArtistImporter()} when the service does not exist.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getArtistImporter()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetArtistImporter_Exception()
    {
        $factory = new ImportFactory(array());
        $factory->getArtistImporter();
    }

    /**
     * Tests {@see ImportFactory::getAlbumImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getAlbumImporter()
     */
    public function testGetAlbumImporter()
    {
        $this->assertInstanceOf(
            'Bc\Bundle\Myd\LastFmBundle\Import\AlbumImporter',
            $this->factory->getAlbumImporter()
        );
    }

    /**
     * Tests {@see ImportFactory::getAlbumImporter()} when the service does not exists.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getAlbumImporter()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetAlbumImporter_Exception()
    {
        $factory = new ImportFactory(array());
        $factory->getAlbumImporter();
    }

    /**
     * Tests {@see ImportFactory::getTrackImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackImporter()
     */
    public function testGetTrackImporter()
    {
        $this->assertInstanceOf(
            'Bc\Bundle\Myd\LastFmBundle\Import\TrackImporter',
            $this->factory->getTrackImporter()
        );
    }

    /**
     * Tests {@see ImportFactory::getTrackImporter()} when the service does not exist.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackImporter()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetTrackImporter_Exception()
    {
        $factory = new ImportFactory(array());
        $factory->getTrackImporter();
    }

    /**
     * Tests {@see ImportFactory::getTrackPlayImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackPlayImporter()
     */
    public function testGetTrackPlayImporter()
    {
        $this->assertInstanceOf(
            'Bc\Bundle\Myd\LastFmBundle\Import\TrackPlayImporter',
            $this->factory->getTrackPlayImporter()
        );
    }

    /**
     * Tests {@see ImportFactory::getTrackPlayImporter()} when the service does not exist.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getTrackPlayImporter()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetTrackPlayImporter_Excetion()
    {
        $factory = new ImportFactory(array());
        $factory->getTrackPlayImporter();
    }

    /**
     * Tests {@see ImportFactory::getUserImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getUserImporter()
     */
    public function testGetUserImporter()
    {
        $this->assertInstanceOf(
            'Bc\Bundle\Myd\LastFmBundle\Import\UserImporter',
            $this->factory->getUserImporter()
        );
    }

    /**
     * Tests {@see ImportFactory::getUserImporter()} when the service does not exist.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getUserImporter()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetUserImporter_Exception()
    {
        $factory = new ImportFactory(array());
        $factory->getUserImporter();
    }
}
