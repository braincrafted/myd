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
     * description
     */
    public function testSetId_GetId()
    {
        $this->track->setId(42);
        $this->assertEquals(42, $this->track->getId());
    }

    /**
     * description
     */
    public function testSetName_GetName()
    {
        $this->track->setName('Street Spirit');
        $this->assertEquals('Street Spirit', $this->track->getName());
    }

    /**
     * description
     */
    public function testSetMbId_GetMbId()
    {
        $this->track->setMbId('ABCDEF');
        $this->assertEquals('ABCDEF', $this->track->getMbId());
    }

    /**
     * description
     */
    public function testSetDuration_GetDuration()
    {
        $this->track->setDuration(101);
        $this->assertEquals(101, $this->track->getDuration());
    }

    /**
     * description
     */
    public function testSetArtist_GetArtist()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $this->track->setArtist($artist);
        $this->assertEquals($artist, $this->track->getArtist());
    }

    /**
     * description
     */
    public function testSetAlbum_GetAlbum()
    {
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $this->track->setAlbum($album);
        $this->assertEquals($album, $this->track->getAlbum());
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
