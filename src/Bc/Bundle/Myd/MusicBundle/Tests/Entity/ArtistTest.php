<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\Artist;

/**
 * ArtistTest
 *
 * @group unit
 */
class ArtistTest extends \PHPUnit_Framework_TestCase
{
    /** @var Artist */
    private $artist;

    public function setUp()
    {
        $this->artist = new Artist();
    }

    /**
     * Tests {@see Artist::__construct()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::__construct()
     */
    public function testConstruct()
    {
        $date = new \DateTime(null, new \DateTimeZone('UTC'));
        $this->assertEquals($date->format('H:i:s'), $this->artist->getCreatedAt()->format('H:i:s'));
    }

    /**
     * Tests {@see setId()} and {@see getId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::setId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getId()
     */
    public function testSetId_GetId()
    {
        $this->artist->setId(42);
        $this->assertEquals(42, $this->artist->getId());
    }

    /**
     * Tests {@see setName()} and {@see getName()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::setName()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getName()
     */
    public function testSetName_GetName()
    {
        $this->artist->setName('Radiohead');
        $this->assertEquals('Radiohead', $this->artist->getName());
    }

    /**
     * Tests {@see setMbid()} and {@see getMbid()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::setMbid()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getMbid()
     */
    public function testSetMbid_GetMbid()
    {
        $this->artist->setMbid('ABCDEF');
        $this->assertEquals('ABCDEF', $this->artist->getMbid());
    }

    /**
     * Tests {@see Artist::addAlbum()} and {@see Artist::getAlbums()}
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::addAlbum()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getAlbums()
     */
    public function testAddAlbum_GetAlbums()
    {
        $album = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Album');
        $this->artist->addAlbum($album);
        $this->assertContains($album, $this->artist->getAlbums());
    }

    /**
     * Tests {@see Artist::addTrack()} and {@see Artist::getTracks()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::addTrack()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getTracks()
     */
    public function testAddTrack_GetTracks()
    {
        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $this->artist->addTrack($track);
        $this->assertContains($track, $this->artist->getTracks());
    }

    /**
     * Tests {@see Artist::setCreatedAt()} and {@see Artist::getCreatedAt()}
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::setCreatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getCreatedAt()
     */
    public function testSetCreatedAt_GetCreatedAt()
    {
        $date = new \DateTime();
        $this->artist->setCreatedAt($date);
        $this->assertEquals($date, $this->artist->getCreatedAt());
    }

    /**
     * Tests {@see Artist::setUpdatedAt()} and {@see Artist::getUpdatedAt()}
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::setUpdatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Artist::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->artist->setUpdatedAt($date);
        $this->assertEquals($date, $this->artist->getUpdatedAt());
    }
}
