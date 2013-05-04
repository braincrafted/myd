<?php

namespace Bc\Bundle\Myd\LastFmBundle\Tests\Import;

use \Mockery as m;

use Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory;

/**
 * ImportFactoryTest
 *
 * @group unit
 */
class ImportFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ImportFactory */
    private $factory;

    /** @var ContainerInterface */
    private $container;

    public function setUp()
    {
        $this->container = m::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->factory = new ImportFactory(array(
            'artist_importer'   => 'Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockArtistImporter'
        ));
        $this->factory->setContainer($this->container);
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Tests {@see ImportFactory::getArtistImporter()}.
     *
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::__construct()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::setContainer()
     * @covers Bc\Bundle\Myd\LastFmBundle\Import\ImportFactory::getArtistImporter()
     */
    public function testGetArtistImporter()
    {
        $this->container
            ->shouldReceive('get')
            ->with('bc_myd_music.artist_manager')
            ->once()
            ->andReturn(new \stdClass());

        $importer = $this->factory->getArtistImporter();
        $this->assertInstanceOf('Bc\Bundle\Myd\LastFmBundle\Tests\Import\MockArtistImporter', $importer);
        $this->assertSame($importer, $this->factory->getArtistImporter(), 'message');
    }
}

class MockArtistImporter
{
    public function __construct($am)
    {
    }
}
