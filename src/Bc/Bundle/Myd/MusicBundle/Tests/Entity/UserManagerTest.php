<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\UserManager;

/**
 * UserManagerTest
 *
 * @group unit
 */
class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\MusicBundle\Tests\Entity\MockUser';

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

        $this->manager = new UserManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see UserManager::createUser()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::createUser()
     */
    public function testCreateUser()
    {
        $this->assertInstanceOf($this->class, $this->manager->createUser());
    }

    /**
     * Tests {@see UserManager::createUser()} with prefilled data.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::createUser()
     */
    public function testCreateUser_WithData()
    {
        $user = $this->manager->createUser(array('username' => 'foo'));

        $this->assertEquals('foo', $user->getUsername());
    }

    /**
     * Tests {@see UserManager::findUsers()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::findUsers()
     */
    public function testFindUsers()
    {
        $user = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($user));

        $this->assertContains($user, $this->manager->findUsers());
    }

    /**
     * Tests {@see UserManager::findUserByUsername()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::findUserByUsername()
     */
    public function testFindUserByUsername()
    {
        $user = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('username' => 'foo'))
            ->once()
            ->andReturn($user);

        $this->assertEquals($user, $this->manager->findUserByUsername('foo'));
    }

    /**
     * Tests {@see UserManager::updateUser()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::updateUser()
     */
    public function testUpdateUser()
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

        $this->manager->updateUser($user, true);
    }

    /**
     * Tests {@see UserManager::updateUser()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::updateUser()
     */
    public function testUpdateUser_WithoutFlush()
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

        $this->manager->updateUser($user, false);
    }

    /**
     * Tests {@see UserManager::flush()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::__construct()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\UserManager::flush()
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

class MockUser extends \Bc\Bundle\Myd\MusicBundle\Entity\User
{
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
