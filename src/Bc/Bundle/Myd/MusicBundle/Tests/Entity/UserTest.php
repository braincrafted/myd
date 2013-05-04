<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\User;

/**
 * UserTest
 *
 * @group unit
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /** @var User */
    private $user;

    public function setUp()
    {
        $this->user = new ConcreteUser();
    }

    /**
     * Tests {@see User::__construct()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::__construct()
     */
    public function testConstruct()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->assertEquals($date->format('H:i'), $this->user->getCreatedAt()->format('H:i'));
    }

    /**
     * Tests {@see User::setId()} and {@see User::getId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::setId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::getId()
     */
    public function testSetId_GetId()
    {
        $this->user->setId(42);
        $this->assertEquals(42, $this->user->getId());
    }

    /**
     * Tests {@see User::addPlay()} and {@see User::getPlay()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::addPlay()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::getPlays()
     */
    public function testAddPlay_GetPlays()
    {
        $play = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\TrackPlay');
        $this->user->addPlay($play);
        $this->assertContains($play, $this->user->getPlays());
    }

    /**
     * Tests {@see User::setCreatedAt()} and {@see User::getCreatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::setCreatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::getCreatedAt()
     */
    public function testSetCreatedAt_GetCreatedAt()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->user->setCreatedAt($date);
        $this->assertEquals($date, $this->user->getCreatedAt());
    }

    /**
     * Tests {@see User::setUpdatedAt()} and {@see User::getUpdatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::setUpdatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\User::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->user->setUpdatedAt($date);
        $this->assertEquals($date, $this->user->getUpdatedAt());
    }
}

class ConcreteUser extends User
{
    public function setUsername($username)
    {
    }

    public function getUsername()
    {
    }
}
