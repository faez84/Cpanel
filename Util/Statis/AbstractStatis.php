<?php
namespace syndex\CpanelBundle\Util\Statis;

/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:54 PM
 */

use syndex\CpanelBundle\Util\Statis\IStatis;

Abstract class AbstractStatis implements IStatis
{
    /**
     *
     * @var
     */
    protected $root;
    /**
     * Doctrine Entity
     *
     * @var
     */
    protected $entity;
    /**
     * Check if the Table Contains delete Field
     *
     * @var
     */
    protected $delete;
    /**
     * @var
     */
    protected $key;
    /**
     * The Object Manager
     *
     * @var
     */
    protected $em;
    /**
     * The Current Object
     *
     * @var
     */
    protected $obj;


    /**
     *Build The Query
     *
     * @return mixed
     */
    Abstract function buildQuery();

    /**
     * Execute the Query
     *
     * @return mixed
     */
    Abstract function executeQuery();

    /**
     * Get The Results
     *
     * @param $result
     * @return mixed
     */
    Abstract function resultQuery(&$result);

    /**
     * AbstractStatis constructor.
     * @param $em
     * @param $root
     * @param $key
     * @param $entity
     */
    public function __construct($em, $root, $key, $entity)
    {
        $this->em = $em;
        $this->root = $root;
        $this->key = $key;
        $this->entity = $entity;
    }

    /**
     * @param $result
     */
    public function execute(&$result){
        $this->buildQuery();
        $this->executeQuery();
        $this->resultQuery($result);
    }

    /**
     * @param $delete
     * @return string
     */
    protected function deleteField(){
        $str = "";
        if ($this->delete) {
            $str .= " and " . self::ENTITY_SYMBOL.'.deleted = 0';
        }

        return $str;
    }

    /**
     * @param $delete
     */
    public function setDelet($delete){
        $this->delete = $delete;
    }

}