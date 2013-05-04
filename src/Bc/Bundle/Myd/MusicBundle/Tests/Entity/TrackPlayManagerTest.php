<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager;

/**
 * TrackPlayManagerTest
 *
 * @group unit
 */
class TrackPlayManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\MusicBundle\Tests\Entity\MockTrackPlay';

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

        $this->manager = new TrackPlayManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see TrackPlayManager::createTrackPlay()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::createTrackPlay()
     */
    public function testCreateTrackPlay()
    {
        $this->assertInstanceOf($this->class, $this->manager->createTrackPlay());
    }

    /**
     * Tests {@see TrackPlayManager::createTrackPlay()} with prefilled data.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::createTrackPlay()
     */
    public function testCreateTrackPlay_WithData()
    {
        $playDate = new \DateTime(null, new \DateTimeZone('UTC'));
        $trackPlay = $this->manager->createTrackPlay(array('playDate' => $playDate));

        $this->assertEquals($playDate, $trackPlay->getPlayDate());
    }

    /**
     * Tests {@see TrackPlayManager::findTrackPlays()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::findTrackPlays()
     */
    public function testFindTrackPlays()
    {
        $trackPlay = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($trackPlay));

        $this->assertContains($trackPlay, $this->manager->findTrackPlays());
    }

    /**
     * Tests {@see TrackPlayManager::findTrackPlayByMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::findTrackPlayByMbId()
     */
    public function testFindTrackPlayByMbId()
    {
        $trackPlay = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('mbId' => 'abcdef'))
            ->once()
            ->andReturn($trackPlay);

        $this->assertEquals($trackPlay, $this->manager->findTrackPlayByMbId('abcdef'));
    }

    /**
     * Tests {@see TrackPlayManager::updateTrackPlay()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::updateTrackPlay()
     */
    public function testUpdateTrackPlay()
    {
        $trackPlay = m::mock($this->class);
        $trackPlay
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($trackPlay)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateTrackPlay($trackPlay, true);
    }

    /**
     * Tests {@see TrackPlayManager::updateTrackPlay()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::updateTrackPlay()
     */
    public function testUpdateTrackPlay_WithoutFlush()
    {
        $trackPlay = m::mock($this->class);
        $trackPlay
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($trackPlay)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateTrackPlay($trackPlay, false);
    }

    /**
     * Tests {@see TrackPlayManager::flush()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlayManager::flush()
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

class MockTrackPlay extends \Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay
{
}
