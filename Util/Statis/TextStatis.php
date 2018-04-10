<?php
namespace syndex\CpanelBundle\Util\Statis;

/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:54 PM
 */

use syndex\CpanelBundle\Util\Statis\AbstractStatis;

class TextStatis extends AbstractStatis
{
    /**
     * @var array
     */
    public $statsdata= array();
    
    /**
     *
     */
    public function buildQuery()
    {
        $this->obj = $this->em->getRepository($this->entity)
            ->createQueryBuilder(self::ENTITY_SYMBOL);
        $where = "1=1";
        $where .= $this->deleteField();
        $select = array();
        foreach ($this->root["fields"] as $filed) {
            array_push($select,  self::ENTITY_SYMBOL."." . $filed["name"]);
        }
        $this->obj->select(join(", ", $select));
        $this->obj->where($where)
            ->orderBy(self::ENTITY_SYMBOL."." . $this->root["orderby"], "DESC")
            ->setMaxResults($this->root["maxresult"]);
    }
    
    /**
     * 
     */
    public function executeQuery()
    {
        $this->statsdata["data"] = $this->obj->getQuery()
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