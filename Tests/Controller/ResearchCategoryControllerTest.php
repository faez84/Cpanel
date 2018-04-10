<?php

namespace syndex\CpanelBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

/**
 * Class UsersController
 */
class ReserachCategoryControllerTest extends WebTestCase
{
    protected $entity;
    protected $cols;
    protected $attrs;
    protected $fileds;
    protected $listfileds = array();
    protected $fileEXCEL;
    protected $resourceFolder = "Users";
    protected $defaultSort = "createdAt";
    protected $step = 20;

    protected $settings = array();
    protected $routs = array();
    protected $from;
    protected $object;
    protected $relations = array();
    public function __construct()
    {
        $this->entity = 'syndexAcademicBundle:Field';
        $this->cols = array("arabicFullName");
        $this->fileds =
            array(
                0 => "id,id",
                1 => "arabicFullName,اسم ",
                2 => "englishFullName,الاسم الانكليزي",
                3 => "parent,المجال الأب",
                4 => "slug,Slug",
                5 => "createdAt,تاريخ الاضافة",
                6 => "lastUpdatedAt,تاريخ آخر تعديل",
                7 => "createdBy,تمت الاضافة بواسطة",
                8 => "lastUpdatedBy,تم التعديل بواسطة",


            );
        $this->fileEXCEL = "Fieldslist.xlsx";
        $this->resourceFolder = "Academia/Field";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "deleted" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "arabicFullName", "deleted" => true,"addedit" => true, "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "englishFullName","addedit" => true, "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
//                3 => array("name" => "children", "list" => false, "type" => "entity", "search" => "", "position" => "bottom",
//                    "displayarrt" => "arabicFullName", "uppertype" => true),
            3 => array("name" => "parent","addedit" => true, "list" => true,
                "type" => "entity", "search" => "", "position" => "bottom",
                "displayarrt" => "arabicFullName",  "isdeleted" => true),
            4 => array("name" => "slug", "type" => "text", "list" => false, "search" => "", "position" => "bottom"),
            5 => array("name" => "createdAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
            6 => array("name" => "lastUpdatedAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
            7 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
            8 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
        );
        $this->settings = array(
            "add" => true,
            "edit" => true,
            "delete" => true, "entname" => "field");

        $this->routs = array("list" => 'syndex_acedemia_field_admin_list',"show" => 'syndex_cpanel_academia_field_show'
        ,"delete" => 'syndex_cpanel_academia_field_deleted', "exportxsl" => 'syndex_cpanel_field_exportxsl'
        , "add" => 'syndex_cpanel_field_add', "edit" => 'syndex_cpanel_field_edit',
            "listdeleted" => 'syndex_acedemia_field_admin_listdeleted'
        );
        $this->form = "cpanel_academia_field_type";
        $this->object = new FieldQuery();
    }
    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return mixed
     */
    public $client;
    public $crawler;

    public function testAddAction()
    {
        $this->client = static::createClient();
        $this->doLogin();
        $this->crawler = $this->client->request('POST', '/cpanelbokamarain/academia/add/field/');
        $form = $this->crawler->selectButton('submit')->form();
        // set some values
        $form['cpanel_academia_field_type[arabicFullName]'] = 'Lucas';
        $form['cpanel_academia_field_type[englishFullName]'] = 'Hey there!';
        $form['cpanel_academia_field_type[parent]'] = 2;
        // submit the form
        $this->crawler = $this->client->submit($form);

        $this->assertFalse($this->client->getResponse()->isRedirect());

    }

    public function testEditAction()
    {
        $this->client = static::createClient();
        $this->doLogin();
        $this->crawler = $this->client->request('POST', '/cpanelbokamarain/academia/field/edit/1');
        $form = $this->crawler->selectButton('submit')->form();
// set some values
        $form['cpanel_academia_field_type[arabicFullName]'] = 'Lucas';
        $form['cpanel_academia_field_type[englishFullName]'] = 'Hey there!';
        $form['cpanel_academia_field_type[parent]'] = 2;
// submit the form
        $this->crawler = $this->client->submit($form);

        // check responce
        //$this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertFalse($this->client->getResponse()->isRedirect());
    }
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
}
