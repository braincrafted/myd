<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUserManager;

/**
 * LastFmUserManagerTest
 *
 * @group unit
 */
class LastFmUserManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\LastFmBundle\Tests\Entity\MockLastFmUser';

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

        $this->manager = new LastFmUserManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see LastFmUserManager::createLastFmUser()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\LastFmUserManager::createLastFmUser
     */
    public function testCreateLastFmUser()
    {
        $this->assertInstanceOf($this->class, $this->manager->createLastFmUser());
    }

    /**
     * Tests {@see LastFmUserManager::findLastFmUsers()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\LastFmUserManager::findLastFmUsers()
     */
    public function testFindLastFmUsers()
    {
        $user = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($user));

        $this->assertContains($user, $this->manager->findLastFmUsers());
    }

    /**
     * Tests {@see LastFmUserManager::findLastFmUserByUsername()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\LastFmUserManager::findLastFmUserByUsername()
     */
    public function testFindLastFmUserByUsername()
    {
        $user = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('username' => 'foobar'))
            ->once()
            ->andReturn($user);

        $this->assertEquals($user, $this->manager->findLastFmUserByUsername('foobar'));
    }

    /**
     * Tests {@see LastFmUserManager::updateLastFmUser()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\LastFmUserManager::findLastFmUser()
     */
    public function testUpdateLastFmUser()
    {
        $user = m::mock($this->class);
        $user
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($user)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateLastFmUser($user, true);
    }

    /**
     * Tests {@see LastFmUserManager::updateLastFmUser()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\LastFmUserManager::findLastFmUser()
     */
    public function testUpdateLastFmUser_WithoutFlush()
    {
        $user = m::mock($this->class);
        $user
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($user)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateLastFmUser($user, false);
    }
}

class MockLastFmUser extends \Bc\Bundle\Myd\LastFmBundle\Entity\LastFmUser
{
}
