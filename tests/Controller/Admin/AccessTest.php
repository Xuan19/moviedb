<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessTest extends WebTestCase
{
    /**
     * @dataProvider getRoutes
     */
    public function testRoutesAsAnonymous($route)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $route);

        $this->assertResponseRedirects();
    }

    /**
     * @dataProvider getRoutes
     */
    public function testRoutesAsAdmin($route)
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'kjacob@yahoo.fr',
            'PHP_AUTH_PW'   => 'Derrick',
        ]);
        $client->request('GET', $route);
         
        if(preg_match('/\/(add|edit)/',$route)){
            $this->assertResponseStatusCodeSame(200);
        }else{

            $this->assertResponseIsSuccessful();
        }
    }

    /**
     * @dataProvider getRoutes
     */
    public function testRoutesAsUser($route)
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jcordier@giraud.fr',
            'PHP_AUTH_PW'   => 'Derrick',
        ]);

        $client->request('GET', $route);

        $this->assertResponseIsSuccessful();
    }


    public function getRoutes()
    {
        return [
            ['/admin?crudAction=index&crudId=025c996'],
            ['/admin/movie'],
            ['/admin/movie/edit/21'],
            ['/admin/movie/add'],
            ['/admin/genre/'],
            ['/admin/genre/edit/24'],
            ['/admin/genre/add'],
        ];
    }
}
