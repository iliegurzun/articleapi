<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractTest;

class ApiControllerTest extends AbstractTest
{
    public function testCreateArticle()
    {
        $this->client->request(
            'POST',
            '/api/articles.json',
            array(),
            array(),
            array('HTTP_ACCEPT' => 'application/json')
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
