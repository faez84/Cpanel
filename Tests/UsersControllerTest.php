<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/8/2017
 * Time: 3:04 PM
 */

namespace syndex\CpanelBundle\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class UsersControllerTest extends WebTestCase
{
    public function enabledAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello-world');
//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Hello World")')->count()
//        );
    }
}