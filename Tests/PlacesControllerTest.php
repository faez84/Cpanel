<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/8/2017
 * Time: 3:04 PM
 */

namespace syndex\CpanelBundle\Tests\Controller;

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
class PlacesControllerTest extends WebTestCase
{
    public function testProfileAction()
    {


        $client = static::createClient();
        $crawler = $client->request('GET', 'CpanelBundle:Places:profile.html.twig', array(


        ));
       

        $this->assertGreaterThan(
            1,
            $crawler->filter('html:contains("الأماكن")')->count()
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