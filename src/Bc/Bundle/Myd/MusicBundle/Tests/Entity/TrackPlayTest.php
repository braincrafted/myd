<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay;

/**
 * TrackPlayTest
 *
 * @group unit
 */
class TrackPlayTest extends \PHPUnit_Framework_TestCase
{
    /** @var TrackPlay */
    private $play;

    public function setUp()
    {
        $this->play = new TrackPlay();
    }

    /**
     * Tests {@see TrackPlay::__construct()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::__construct()
     */
    public function testConstruct()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->assertEquals($date->format('H:i:s'), $this->play->getCreatedAt()->format('H:i:s'));
    }

    /**
     * Tests {@see TrackPlay::setId()} and {@see TrackPlay::getId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getId()
     */
    public function testSetId_GetId()
    {
        $this->play->setId(42);
        $this->assertEquals(42, $this->play->getId());
    }

    /**
     * Tests {@see TrackPlay::setTrack()} and {@see TrackPlay::getTrack()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setTrack()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getTrack()
     */
    public function testSetTrack_GetTrack()
    {
        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $this->play->setTrack($track);
        $this->assertEquals($track, $this->play->getTrack());
    }

    /**
     * Tests {@see TrackPlay::setUser()} and {@see TrackPlay::getUser()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setUser()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getUser()
     */
    public function testSetUser_GetUser()
    {
        $user = m::mock('Bc\Bundle\Myd\MusicBundle\Model\UserInterface');
        $this->play->setUser($user);
        $this->assertEquals($user, $this->play->getUser());
    }

    /**
     * Tests {@see TrackPlay::setPlayDate()} and {@see TrackPlay::getPlayDate()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setPlayDate()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getPlayDate()
     */
    public function testSetPlayDate_GetPlayDate()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->play->setPlayDate($date);
        $this->assertEquals($date, $this->play->getPlayDate());
    }

    /**
     * Tests {@see TrackPlay::setCreatedAt()} and {@see TrackPlay::getCreatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setCreatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getCreatedAt()
     */
    public function testSetCreatedAt_GetCreatedAt()
    {
        $date = new \DateTime();
        $this->play->setCreatedAt($date);
        $this->assertEquals($date, $this->play->getCreatedAt());
    }

    /**
     * Tests {@see TrackPlay::setUpdatedAt()} and {@see TrackPlay::getUpdatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::setUpdatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->play->setUpdatedAt($date);
        $this->assertEquals($date, $this->play->getUpdatedAt());
    }
}
