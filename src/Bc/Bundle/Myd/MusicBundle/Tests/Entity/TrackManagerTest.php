<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackManager;

/**
 * TrackManagerTest
 *
 * @group unit
 */
class TrackManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\MusicBundle\Tests\Entity\MockTrack';

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

        $this->manager = new TrackManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see TrackManager::createTrack()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::createTrack()
     */
    public function testCreateTrack()
    {
        $this->assertInstanceOf($this->class, $this->manager->createTrack());
    }

    /**
     * Tests {@see TrackManager::createTrack()} with prefilled data.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::createTrack()
     */
    public function testCreateTrack_WithData()
    {
        $track = $this->manager->createTrack(array(
            'name'          => 'Angels',
            'mbid'          => 'ca4a7e9c-97a3-4a6a-97a1-f9c6c2e8cf57',
            'duration'      => 360
        ));

        $this->assertEquals('Angels', $track->getName());
        $this->assertEquals('ca4a7e9c-97a3-4a6a-97a1-f9c6c2e8cf57', $track->getMbid());
        $this->assertEquals(360, $track->getDuration());
    }

    /**
     * Tests {@see TrackManager::findTracks()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTracks()
     */
    public function testFindTracks()
    {
        $track = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($track));

        $this->assertContains($track, $this->manager->findTracks());
    }

    /**
     * Tests {@see TrackManager::findTrackByMbid()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTrackByMbid()
     */
    public function testFindTrackByMbid()
    {
        $track = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('mbid' => 'abcdef'))
            ->once()
            ->andReturn($track);

        $this->assertEquals($track, $this->manager->findTrackByMbid('abcdef'));
    }

    /**
     * Tests {@see TrackManager::findTrackByAlbumAndName()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTrackByAlbumAndName()
     */
    public function testFindTrackByAlbumAndName()
    {
        $track = m::mock($this->class);
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('album' => $album, 'name' => 'Karma Police'))
            ->once()
            ->andReturn($track);

        $this->assertEquals($track, $this->manager->findTrackByAlbumAndName($album, 'Karma Police'));
    }

    /**
     * Tests {@see TrackManager::updateTrack()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::updateTrack()
     */
    public function testUpdateTrack()
    {
        $track = m::mock($this->class);
        $track
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($track)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateTrack($track, true);
    }

    /**
     * Tests {@see TrackManager::updateTrack()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::updateTrack()
     */
    public function testUpdateTrack_WithoutFlush()
    {
        $track = m::mock($this->class);
        $track
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($track)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateTrack($track, false);
    }

    /**
     * Tests {@see TrackManager::flush()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::flush()
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

class MockTrack extends \Bc\Bundle\Myd\MusicBundle\Entity\Track
{
}
