<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager;

/**
 * AlbumManagerTest
 *
 * @group unit
 */
class AlbumManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $class = 'Bc\Bundle\Myd\MusicBundle\Tests\Entity\MockAlbum';

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

        $this->manager = new AlbumManager($this->om, $this->class);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see AlbumManager::createAlbum()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager::createAlbum
     */
    public function testCreateAlbum()
    {
        $this->assertInstanceOf($this->class, $this->manager->createAlbum());
    }

    /**
     * Tests {@see AlbumManager::findAlbums()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager::findAlbums()
     */
    public function testFindAlbums()
    {
        $album = m::mock($this->class);

        $this->repository
            ->shouldReceive('findAll')
            ->withNoArgs()
            ->once()
            ->andReturn(array($album));

        $this->assertContains($album, $this->manager->findAlbums());
    }

    /**
     * Tests {@see AlbumManager::findAlbumByMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager::findAlbumByMbId()
     */
    public function testFindAlbumByMbId()
    {
        $album = m::mock($this->class);

        $this->repository
            ->shouldReceive('findOneBy')
            ->with(array('mbId' => 'abcdef'))
            ->once()
            ->andReturn($album);

        $this->assertEquals($album, $this->manager->findAlbumByMbId('abcdef'));
    }

    /**
     * Tests {@see AlbumManager::updateAlbum()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager::findAlbum()
     */
    public function testUpdateAlbum()
    {
        $album = m::mock($this->class);
        $album
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($album)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->once();

        $this->manager->updateAlbum($album, true);
    }

    /**
     * Tests {@see AlbumManager::updateAlbum()} with $andFlush = false.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\AlbumManager::findAlbum()
     */
    public function testUpdateAlbum_WithoutFlush()
    {
        $album = m::mock($this->class);
        $album
            ->shouldReceive('setUpdatedAt')
            ->withAnyArgs()
            ->once();

        $this->om
            ->shouldReceive('persist')
            ->with($album)
            ->once();
        $this->om
            ->shouldReceive('flush')
            ->withNoArgs()
            ->never();

        $this->manager->updateAlbum($album, false);
    }
}

class MockAlbum extends \Bc\Bundle\Myd\MusicBundle\Entity\Album
{
}
