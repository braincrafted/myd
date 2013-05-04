<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\UserImporter;

/**
 * UserImporterTest
 *
 * @group unit
 */
class UserImporterTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserImporter */
    private $importer;

    /** @var UserManager */
    private $userManager;

    public function setUp()
    {
        $this->userManager = m::mock('Bc\Bundle\Myd\MusicBundle\Entity\UserManager');

        $this->importer = new UserImporter($this->userManager);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see UserImporter::import()}.
     *
     * The user is NOT IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\UserImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\UserImporter::import()
     */
    public function testImport_NoDb()
    {
        $user = m::mock('Bc\Bundle\Myd\MusicBundle\Model\UserInterface');

        $this->userManager
            ->shouldReceive('findUserByUsername')
            ->with('foobar')
            ->once()
            ->andReturn(null);

        $this->userManager
            ->shouldReceive('createUser')
            ->with(array('username' => 'foobar'))
            ->once()
            ->andReturn($user);
        $this->userManager
            ->shouldReceive('updateUser')
            ->with($user)
            ->once();

        $result = $this->importer->import('foobar');

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Model\UserInterface', $result);
    }

    /**
     * Tests {@see UserImporter::import()}.
     *
     * The user is IN the database.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\UserImporter::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\UserImporter::import()
     */
    public function testImport_Db()
    {
        $user = m::mock('Bc\Bundle\Myd\MusicBundle\Model\UserInterface');

        $this->userManager
            ->shouldReceive('findUserByUsername')
            ->with('foobar')
            ->once()
            ->andReturn($user);

        $this->userManager
            ->shouldReceive('createUser')
            ->never();
        $this->userManager
            ->shouldReceive('updateUser')
            ->never();

        $result = $this->importer->import('foobar');

        $this->assertInstanceOf('Bc\Bundle\Myd\MusicBundle\Model\UserInterface', $result);
    }
}
