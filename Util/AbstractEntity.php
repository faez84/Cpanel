<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 12:56 AM
 */
namespace syndex\CpanelBundle\Util;

use FOS\UserBundle\Model\User;
use Symfony\Component\HttpFoundation\Request;
use syndex\CpanelBundle\Model\QueryInterface;
use syndex\CpanelBundle\Services\FileService;
/**
 * Interface QueryInterface
 */

abstract class AbstractEntity implements QueryInterface
{
    /**
     * The Current Object
     * 
     * @var
     */
    public $object;
    /**
     * Doctrine Entity
     * 
     * @var
     */
    public $entity;
    /**
     * Fields 
     * 
     * @var array
     */
    public $cols = [];
    /**
     * Exported Fields
     * 
     * @var
     */
    public $fileds;
    /**
     * Listed Fields
     * 
     * @var array
     */
    public $listfileds = array();
    /**
     * Name Of the Exported File
     * 
     * @var
     */
    public $fileEXCEL;
    /**
     * Path to the Resources Folder
     * 
     * @var string
     */
    public $resourceFolder = "Users";
    /**
     * Default Sort Field 
     * 
     * @var string
     */
    public $defaultSort = "createdAt";
    /**
     * Number For Listed Rows in Every Page
     * 
     * @var int
     */
    public $step = 20;
    /**
     * Settings
     * 
     * @var array
     */
    public $settings = array();
    /**
     * Routs (Old Controller)
     * 
     * @var array
     */
    public $routs = array();
    /**
     * FormType
     * 
     * @var
     */
    public $from;
    
    public $relations = array();
    /**
     * Cache
     * 
     * @var
     */
    public  $cache;
    public $role;
    /**
     * Custom View Pages
     * 
     * @var array
     */
    public $customView = array();
    /**
     * @param $args
     * @return mixed
     */
    public static function makeQuery($args)
    {
    }

    /**
     * Pre Insert 
     * 
     * @param FileService $pupService
     * @param Request $request
     */
    public function preInsert(FileService $pupService, Request $request)
    {
        return;
    }

    /**
     * Insert
     * 
     * @param User $user
     */
    public  function insert(User $user){
        return;
    }

    /**
     * Initiate Update
     */
    public  function initUpdate(){
        return;
    }

    /**
     * Pre Update
     * 
     * @param FileService $pupService
     * @param Request $request
     */
    public function preUpdate(FileService $pupService, Request $request)
    {
        return;
    }

    /**
     * Update
     * 
     * @param User $user
     */
    public  function update(User $user){
        return;
    }

    /**
     * Check Validation
     * 
     * @param $form
     * @return array
     */
    public  function CheckValidation($form){
        $validationArr = [];
        $validationArr["valid"] = true;
        return $validationArr;
    }

}