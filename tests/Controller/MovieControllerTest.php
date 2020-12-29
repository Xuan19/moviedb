<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieControllerTest extends WebTestCase
{
    public function testAnonymous()
    {
        $client = static::createClient();

        
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'MovieDB');
        $this->assertSelectorExists('nav.navbar');

        $client->request('GET','/admin/movie');

        $this->assertResponseRedirects();
    }

    public function testUser()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jcordier@giraud.fr',
            'PHP_AUTH_PW'   => 'Derrick',
        ]);


        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $client->request('GET','/admin/movie');
        $this->assertResponseIsSuccessful();

        $client->request('GET','/admin/movie/edit/21');
        $this->assertResponseIsSuccessful();

        //l'autorization à vérifier
        //$this->assertResponseStatusCodeSame(403);
    }


    public function testAdmin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'kjacob@yahoo.fr',
            'PHP_AUTH_PW'   => 'Derrick',
        ]);
        
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $client->request('GET','/admin/movie');
        $this->assertResponseIsSuccessful();

        $client->request('GET','/admin/movie/edit/21');
        $this->assertResponseIsSuccessful();

    }

}
