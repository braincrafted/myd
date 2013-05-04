<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\Track;

/**
 * TrackTest
 *
 * @group unit
 */
class TrackTest extends \PHPUnit_Framework_TestCase
{
    /** @var Track */
    private $track;

    public function setUp()
    {
        $this->track = new Track();
    }

    /**
     * Tests {@see Track::__construct()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::__construct()
     */
    public function testConstruct()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->assertEquals($date->format('H:i:s'), $this->track->getCreatedAt()->format('H:i:s'));
    }

    /**
     * Tests {@see Track::setId()} and {@see Track::getId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getId()
     */
    public function testSetId_GetId()
    {
        $this->track->setId(42);
        $this->assertEquals(42, $this->track->getId());
    }

    /**
     * Tests {@see Track::setName()} and {@see Track::getName()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setName()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getName()
     */
    public function testSetName_GetName()
    {
        $this->track->setName('Street Spirit');
        $this->assertEquals('Street Spirit', $this->track->getName());
    }

    /**
     * Tests {@see Track::setMbId()} and {@see Track::getMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setMbId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getMbId()
     */
    public function testSetMbId_GetMbId()
    {
        $this->track->setMbId('ABCDEF');
        $this->assertEquals('ABCDEF', $this->track->getMbId());
    }

    /**
     * Tests {@see Track::setDuration()} and {@see Track::getDuration()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setDuration()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getDuration()
     */
    public function testSetDuration_GetDuration()
    {
        $this->track->setDuration(101);
        $this->assertEquals(101, $this->track->getDuration());
    }

    /**
     * Tests {@see Track::setArtist()} and {@see Track::getArtist()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setArtist()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getArtist()
     */
    public function testSetArtist_GetArtist()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $this->track->setArtist($artist);
        $this->assertEquals($artist, $this->track->getArtist());
    }

    /**
     * Tests {@see Track::setAlbum()} and {@see Track::getAlbum()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setAlbum()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getAlbum()
     */
    public function testSetAlbum_GetAlbum()
    {
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $this->track->setAlbum($album);
        $this->assertEquals($album, $this->track->getAlbum());
    }

    /**
     * Tests {@see Track::addPlay()} and {@see Track::getPlay()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::addPlay()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getPlays()
     */
    public function testAddPlay_GetPlays()
    {
        $play = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay');
        $this->track->addPlay($play);
        $this->assertContains($play, $this->track->getPlays());
    }

    /**
     * Tests {@see Track::setCreatedAt()} and {@see Track::getCreatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setCreatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getCreatedAt()
     */
    public function testSetCreatedAtDate_GetCreatedAtDate()
    {
        $date = new \DateTime();
        $this->track->setCreatedAt($date);
        $this->assertEquals($date, $this->track->getCreatedAt());
    }

    /**
     * Tests {@see Track::setUpdatedAt()} and {@see Track::getUpdatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::setUpdatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Track::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->track->setUpdatedAt($date);
        $this->assertEquals($date, $this->track->getUpdatedAt());
    }
}
