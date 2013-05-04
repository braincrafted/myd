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
     * Tests {@see LastFmUser::__contruct()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser::__construct()
     */
    public function testConstruct()
    {
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $this->user->getPlays());
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
}
