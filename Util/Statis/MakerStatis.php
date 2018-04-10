<?php
namespace syndex\CpanelBundle\Util\Statis;

/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:54 PM
 */

use syndex\CpanelBundle\Util\Statis\AxisesStatis;
use syndex\CpanelBundle\Util\Statis\QueryStatis;
use syndex\CpanelBundle\Util\Statis\TextStatis;

class MakerStatis
{
    /**
     * @var array
     */
    private $root;
    private $entity;
    private $result;
    private $em;

    /**
     * MakerStatis constructor.
     * @param $em
     * @param $root
     * @param $entity
     * @param $result
     */
    public function __construct($em, $root, $entity, &$result)
    {

        $this->em = $em;
        $this->root = $root;
        $this->entity = $entity;
        $this->result = &$result;
      
    }

    /**
     * Execute Axises Stats
     * 
     */
    public function executeAxisesStatis()
    {
        for ($i = 0; $i < sizeof($this->root["axises"]); $i = $i + 1) {

            $zas = new AxisesStatis($this->em, $this->root["axises"][$i], $i, $this->entity);
            $zas->execute($this->result);
        }
    }

    /**
     * Execute Query Stats
     * 
     */
    public function executeQueryStatis()
    {
        for ($i = 0; $i < sizeof($this->root["plainquery"]); $i = $i + 1) {

            $zas = new QueryStatis($this->em, $this->root["plainquery"][$i], $i, $this->entity);
            $zas->setDelet($this->root["delete"]);
            $zas->execute($this->result);
        }
    }

    /**
     * Execute Text Stats
     * 
     */
    public function executeTextStatis()
    {
        for ($i = 0; $i < sizeof($this->root["textstats"]); $i = $i + 1) {

            $zas = new TextStatis($this->em, $this->root["textstats"][$i], $i, $this->entity);
            $zas->setDelet($this->root["delete"]);
            $zas->execute($this->result);
        }
    }
}