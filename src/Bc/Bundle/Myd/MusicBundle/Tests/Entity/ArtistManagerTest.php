<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager;

/**
 * ArtistManagerTest
 *
 * @group unit
 */
class ArtistManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\MusicBundle\Tests\Entity\MockArtist';

    /** @var ObjectManager */
    private $om;

    public function setUp()
    {
        $this->repository = m::mock('Doctrine\Common\Persistence\ObjectRepository');

        $metadata = m::mock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $metadata
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn($this->class);

        $this->om = m::mock('Doctrine\Common\Persistence\ObjectManager');
        $this->om
            ->shouldReceive('getRepository')
            ->with($this->class)
            ->once()
            ->andReturn($this->repository);
        $this->om
            ->shouldReceive('getClassMetadata')
            ->with($this->class)
            ->once()
            ->andReturn($metadata);

        $this->manager = new ArtistManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see ArtistManager::createArtist()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::createArtist()
     */
    public function testCreateArtist()
    {
        $this->assertInstanceOf($this->class, $this->manager->createArtist());
    }

    /**
     * Tests {@see ArtistManager::createArtist()} with prefilled data.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::createArtist()
     */
    public function testCreateArtist_WithData()
    {
        $artist = $this->manager->createArtist(array(
            'name'  => 'The Thermals',
            'mbId'  => '7cd2d860-c6d7-4be2-af50-57c51ee45687'
        ));

        $this->assertEquals('The Thermals', $artist->getName());
        $this->assertEquals('7cd2d860-c6d7-4be2-af50-57c51ee45687', $artist->getMbId());
    }

    /**
     * Tests {@see ArtistManager::findArtists()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::findArtists()
     */
    public function testFindArtists()
    {
        $artist = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($artist));

        $this->assertContains($artist, $this->manager->findArtists());
    }

    /**
     * Tests {@see ArtistManager::findArtistByMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::findArtistByMbId()
     */
    public function testFindArtistByMbId()
    {
        $artist = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('mbId' => 'abcdef'))
            ->once()
            ->andReturn($artist);

        $this->assertEquals($artist, $this->manager->findArtistByMbId('abcdef'));
    }

    /**
     * Tests {@see ArtistManager::updateArtist()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::updateArtist()
     */
    public function testUpdateArtist()
    {
        $artist = m::mock($this->class);
        $artist
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($artist)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateArtist($artist, true);
    }

    /**
     * Tests {@see ArtistManager::updateArtist()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::updateArtist()
     */
    public function testUpdateArtist_WithoutFlush()
    {
        $artist = m::mock($this->class);
        $artist
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($artist)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateArtist($artist, false);
    }

    /**
     * Tests {@see ArtistManager::flush()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\ArtistManager::flush()
     */
    public function testFlush()
    {
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->flush();
    }
}

class MockArtist extends \Bc\Bundle\Myd\MusicBundle\Entity\Artist
{
}
