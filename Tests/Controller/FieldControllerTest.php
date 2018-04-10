<?php

namespace syndex\CpanelBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Exception\Exception;
use syndex\CpanelBundle\Model\FieldQuery;
use syndex\SearchBundle\ElasticSearch\Displayer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use syndex\SearchBundle\ElasticSearch\pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use syndex\BazaarBundle\Entity\Product;
use syndex\UserBundle\Entity\User;
use FOS\RestBundle\View\View;
use syndex\BazaarBundle\Entity\Media;
use syndex\BazaarBundle\Entity\ProductAttributes;
use syndex\CpanelBundle\Model\AdminAbstract;
use syndex\AcademicBundle\Entity\Tag;
use syndex\AcademicBundle\Entity\ResearchesContributersRoles;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use syndex\CpanelBundle\Services\CacheService;
use Doctrine\Common\Cache\RedisCache;

/**
 * Class UsersController
 */
class FieldControllerTest extends WebTestCase
{
    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return mixed
     */
    //Pleas change name of database and host and username of database in config_test
    //add a configurate that located in test subfolder in Shamara folder to Phpdist.xml file
    public $client;
    public $crawler;
    public $crawler2;

//    public function testAddAction()
//    {
//        $this->client = static::createClient();
//        $this->doLogin();
//        //U need to add FieldController
//        $this->crawler = $this->client->request('POST', '/cpanelbokamarain/academia/add/field/');
//        $form = $this->crawler->selectButton('submit')->form();
//        // set some values
//        $form['cpanel_academia_field_type[arabicFullName]'] = 'Lucas';
//        $form['cpanel_academia_field_type[englishFullName]'] = 'Hey there!';
//        $form['cpanel_academia_field_type[parent]'] = 2;
//        // submit the form
//        $this->crawler = $this->client->submit($form);
//        $this->assertFalse($this->client->getResponse()->isRedirect());
//    }
//    public function testAddAction()
//    {
//        $this->client = static::createClient();
//        $this->doLogin();
//
//        $this->crawler = $this->client->request('POST', '/cpanelbokamarain/academia/field/nadd');
//        $form = $this->crawler->selectButton('submit')->form();
//        // set some values
//        $form['cpanel_academia_field_type[arabicFullName]'] = 'Lucas';
//        $form['cpanel_academia_field_type[englishFullName]'] = 'Hey there!';
//        $form['cpanel_academia_field_type[parent]'] = 2;
//        // submit the form
//        $this->crawler = $this->client->submit($form);
//        $this->assertFalse($this->client->getResponse()->isRedirect());
//    }
    public function tesmmtAddAction()
    {
        $this->client = static::createClient();
        $this->doLogin();
        //U need to add FieldController
        $this->crawler = $this->client->request('POST', '/cpanelbokamarain/academia/field/nlist');
          $link =   $this->crawler
            ->filter('a:contains("إضافة")') // find all links with the text "Greet"
            ->eq(2) // select the second link in the list
            ->link();
        $this->crawler2 = $this->client->click($link);
//
//        $this->assertArrayHasKey('routs', $this->crawler);

//        $this->assertGreaterThan(
//            0,
//            $this->crawler2->filter('html:contains("الاسم")')->count()
//        );
//        $this->assertCount(
//            65,
//            $this->crawler2->filter('a')
//        );

//        $this->assertContains('إضافة',  $this->client->getResponse()->getContent());

        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $this->client->getResponse()->getStatusCode()
        );
    }
//    public function testException()
//    {
//        $this->expectException(InvalidArgumentException::class);
//    }

//    /**
//     * @depends testProducerFirst
//     * @depends testProducerSecond
//     * @dataProvider provider
//     */
//    public function testConsumer()
//    {
//        $this->assertEquals(
//            ['provider2', 'first', 'second'],
//            func_get_args()
//        );
//    }
    /**
     * Do login with username
     *
     * @param string $username
     */
    private function doLogin()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('_submit')->form(array(
            '_username' => "faez",
            '_password' => '123Qwe456'
        ));
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->client->followRedirects();
    }


    protected $RedisCache;

    protected function setUp() {
        $this->RedisCache = $this->getMockBuilder('Doctrine\Common\Cache\RedisCache')

            ->getMock();


        // Configure the stub.

        $this->RedisCache = new \Redis();
       //$this->RedisCache->
        $ok = @$this->RedisCache->connect('127.0.0.1');
        if (!$ok) {
            $this->markTestSkipped('Cannot connect to Redis.');
        }
    }

    public function testRedis()
    {
        $this->RedisCache->set("t", 66);


        $this->assertEquals(66,  $this->RedisCache->get("t"));
    }
        public function tesnntErrorReported()
    {
        // Create a mock for the Observer class,
        // only mock the update() method.
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $observer->expects($this->once())
            ->method('update')
            ->with($this->equalTo('something'));

        // Create a Subject object and attach the mocked
        // Observer object to it.
        $subject = new Subject('My subject');
        $subject->attach($observer);

        // Call the doSomething() method on the $subject object
        // which we expect to call the mocked Observer object's
        // update() method with the string 'something'.
        $subject->doSomething();
    }

   
}
class SomeClass
{
    public function doSomething()
    {
        // Do something.
    }
}
class Subject
{
    protected $observers = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething()
    {
        // Do something.
        // ...

        // Notify observers that we did something.
        $this->notify('something');
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }

    // Other methods.
}

class Observer
{
    public function update($argument)
    {
        // Do something.
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // Do something
    }

    // Other methods.

}
