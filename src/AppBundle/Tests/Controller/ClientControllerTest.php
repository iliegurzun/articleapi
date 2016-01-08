<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractTest;
/**
 * Description of ClientControllerTest
 *
 * @author Ilie
 */
class ClientControllerTest extends AbstractTest
{
    public function testClientCreateArticle()
    {
        $crawler = $this->client->request('GET', '/create-article');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('form', $this->client->getResponse()->getContent());
        
        $crawler = $this->client->request(
            'POST', 
            '/create-article', 
            array(
                'article' => array(
                    'title'   => 'foo',
                    'content' => 'bar',
                    'author'  => 'foobar'
                )
            )
        );
        
        $this->assertContains(
            'That is not a valid username', 
            $this->client->getResponse()->getContent()
        );
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
