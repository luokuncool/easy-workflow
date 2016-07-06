<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultControllerTest extends WebTestCase
{
    /** @var  ContainerInterface */
    private $container;
    /** @var  Client */
    private $client;

    protected function setUp()
    {
        parent::setUp();
        parent::bootKernel();
        $this->container = parent::$kernel->getContainer();
        $this->client    = static::createClient(
            array(),
            array(
                'PHP_AUTH_USER' => 'quentin',
                'PHP_AUTH_PW'   => 'quentinpwd',
            )
        );
    }

    public function testIndex()
    {
        $this->client->enableProfiler();
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}