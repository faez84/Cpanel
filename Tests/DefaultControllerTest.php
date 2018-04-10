<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/17/2017
 * Time: 6:23 PM
 */

namespace syndex\CpanelBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class DefaultControllerTest  extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post/hello-world');
//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Hello World")')->count()
//        );
    }
}