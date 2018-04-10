<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/8/2017
 * Time: 3:04 PM
 */

namespace syndex\CpanelBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use syndex\SearchBundle\ElasticSearch\Displayer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use syndex\SearchBundle\ElasticSearch\pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use syndex\AdminBundle\Entity\IndexChoices;
/**
 * Class PostControllerTest
 * @package syndex\CpanelBundle\Tests
 */
class BazarControllerTest extends WebTestCase
{
    public function testProductsStatsAction()
    {


        $client = static::createClient();
        $crawler = $client->request('GET', 'CpanelBundle:Bazar:statsValue.html.twig', array(


        ));
       

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("OK")')->count()
        );
//
//        return $this->render('CpanelBundle:Bazar:statsValue.html.twig', array(
//            'stat1' => $bazaar_product,
//            'stat2' => $bazaar_product_d,
//            'stat3' => $bazaar_product_notd,
//            'stat1trans' => 'bazar.allprods',
//            'stat2trans' => 'bazar.dprods',
//            'stat3trans' => 'bazar.notdprods',
//            'cats' => 'bazar.products',
//            'addeddivs' => $addeddivs,
//
//        ));


    }


}