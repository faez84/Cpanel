<?php
namespace syndex\CpanelBundle\Util\Statis;

/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:54 PM
 */

use syndex\CpanelBundle\Util\Statis\AbstractStatis;

class QueryStatis extends AbstractStatis
{
    public $statsdata = array();

    /**
     * 
     */
    public function buildQuery()
    {
        $this->obj = $this->em->createQuery(
            $this->root["query"]
        );
        $this->obj->setMaxResults($this->root["maxresult"]);
    }

    /**
     * 
     */
    public function executeQuery()
    {
        $this->statsdata["data"] = $this->obj
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * @param $result
     */
    public function resultQuery(&$result)
    {
        $this->statsdata["type"] = "textstats";
        $this->statsdata["title"] = $this->root["title"];
        $this->statsdata["fields"] = $this->root["fields"];
        array_push($result, $this->statsdata);
    }

}