<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser;

/**
 * LastFmUserTest
 *
 * @group unit
 */
class LastFmUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var LastFmUser */
    private $user;

    public function setUp()
    {
        $this->user = new LastFmUser();
    }

    /**
     * Tests {@see LastFmUser::setId()} and {@see LastFmUser::getId()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setId()
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::getId()
     */
    public function testSetId_GetId()
    {
        $this->user->setId(42);
        $this->assertEquals(42, $this->user->getId());
    }

    /**
     * Tests {@see LastFmUser::setUsername()} and {@see LastFmUser::getUsername()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setUsername()
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::getUsername()
     */
    public function testSetUsername_GetUsername()
    {
        $this->user->setUsername('foobar');
        $this->assertEquals('foobar', $this->user->getUsername());
    }

    /**
     * Tests {@see LastFmUser::addPlay()} and {@see LastFmUser::getPlays()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::addPlay()
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::getPlays()
     */
    public function testAddPlay_GetPlays()
    {
        $play = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay');
        $this->user->addPlay($play);
        $this->assertContains($play, $this->user->getPlays());
    }

    /**
     * Tests {@see LastFmuser::setCreatedAt()} and {@see LastFmUser::getCreatedAt()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setCreatedAt()
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setUpdatedAt()
     */
    public function testSetCreatedAt_GetCreatedAt()
    {
        $date = new \DateTime();
        $this->user->setCreatedAt($date);
        $this->assertEquals($date, $this->user->getCreatedAt());
    }

    /**
     * Tests {@see LastFmuser::setUpdatedAt()} and {@see LastFmUser::getUpdatedAt()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setUpdatedAt()
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::setUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->user->setUpdatedAt($date);
        $this->assertEquals($date, $this->user->getUpdatedAt());
    }
}
