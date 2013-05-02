<?php

namespace Bc\Bundle\Myd\MusicBundle\Tests\Entity;

use \Mockery as m;

use Bc\Bundle\Myd\MusicBundle\Entity\Album;

/**
 * AlbumTest
 *
 * @group unit
 */
class AlbumTest extends \PHPUnit_Framework_TestCase
{
    /** @var Album */
    private $album;

    public function setUp()
    {
        $this->album = new Album();
    }

    /**
     * Tests {@see Album::setId()} and {@see Album::getId()}
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getId()
     */
    public function testSetId_GetId()
    {
        $this->album->setId(42);
        $this->assertEquals(42, $this->album->getId());
    }

    /**
     * Tests {@see Album::setName()} and {@see Album::getName()}
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setName()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getName()
     */
    public function testSetName_GetName()
    {
        $this->album->setName('OK Computer');
        $this->assertEquals('OK Computer', $this->album->getName());
    }

    /**
     * Tests {@see Album::setArtist()} and {@see Album::getArtist()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setArtist()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getArtist()
     */
    public function testSetArtist_GetArtist()
    {
        $artist = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Artist');
        $this->album->setArtist($artist);
        $this->assertEquals($artist, $this->album->getArtist());
    }

    /**
     * Tests {@see Album::setMbId()} and {@see Album::getMbId()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setMbId()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getMbId()
     */
    public function testSetMbId_GetMbId()
    {
        $this->album->setMbId('ABCDEF');
        $this->assertEquals('ABCDEF', $this->album->getMbId());
    }

    /**
     * Tests {@see Album::addTrack()} and {@see Album::getTracks()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::addTrack()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getTracks()
     */
    public function testAddTrack_GetTracks()
    {
        $track = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\Track');
        $this->album->addTrack($track);
        $this->assertContains($track, $this->album->getTracks());
    }

    /**
     * Tests {@see Album::setReleaseDate()} and {@see Album::getReleaseDate()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setReleaseDate()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getReleaseDate()
     */
    public function testSetReleaseDate_GetReleaseDate()
    {
        $date = new \DateTime();
        $this->album->setReleaseDate($date);
        $this->assertEquals($date, $this->album->getReleaseDate());
    }

    /**
     * Tests {@see Album::setCreatedAt()} and {@see Album::getCreatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setCreatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getCreatedAt()
     */
    public function testSetCreatedAtDate_GetCreatedAtDate()
    {
        $date = new \DateTime();
        $this->album->setCreatedAt($date);
        $this->assertEquals($date, $this->album->getCreatedAt());
    }

    /**
     * Tests {@see Album::setUpdatedAt()} and {@see Album::getUpdatedAt()}.
     *
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::setUpdatedAt()
     * @covers Bc\Bundle\Myd\MusicBundle\Entity\Album::getUpdatedAt()
     */
    public function testSetUpdatedAt_GetUpdatedAt()
    {
        $date = new \DateTime();
        $this->album->setUpdatedAt($date);
        $this->assertEquals($date, $this->album->getUpdatedAt());
    }
}
