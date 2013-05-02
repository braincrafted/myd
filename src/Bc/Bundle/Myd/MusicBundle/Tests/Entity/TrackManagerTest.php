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
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::createTrack
     */
    public function testCreateTrack()
    {
        $this->assertInstanceOf($this->class, $this->manager->createTrack());
    }

    /**
     * Tests {@see TrackManager::findTracks()}.
     *
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
     * Tests {@see TrackManager::findTrackByMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTrackByMbId()
     */
    public function testFindTrackByMbId()
    {
        $track = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('mbId' => 'abcdef'))
            ->once()
            ->andReturn($track);

        $this->assertEquals($track, $this->manager->findTrackByMbId('abcdef'));
    }

    /**
     * Tests {@see TrackManager::updateTrack()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTrack()
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
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackManager::findTrack()
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
}

class MockTrack extends \Bc\Bundle\Myd\MusicBundle\Entity\Track
{
}
