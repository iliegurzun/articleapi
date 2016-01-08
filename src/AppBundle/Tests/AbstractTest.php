<?php
namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of AbstractTest
 *
 * @author Ilie
 */
abstract class AbstractTest extends WebTestCase
{
    protected $client;
    protected $em;
    protected $container;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        $this->client = static::createClient();
        $this->container = static::$kernel->getContainer();
    }
}
