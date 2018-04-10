<?php
namespace syndex\CpanelBundle\Util\Statis;

/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:54 PM
 */

use syndex\CpanelBundle\Util\Statis\AbstractStatis;

class AxisesStatis extends AbstractStatis
{
    /**
     * @var array
     */
    public $xs = array();
    public $ys = array();
    /**
     *
     */
    public function buildQuery()
    {
        $this->obj = $this->em->getRepository($this->entity)
            ->createQueryBuilder(self::ENTITY_SYMBOL);

        switch ($this->root["ytype"]) {
            case "datetime":
                $selecty = "DATE_FORMAT(e." . $this->root["y"] . ",'%d-%m-%Y') AS " . $this->root["y"];
                break;
            case "entity":
                $selecty = chr(65 + $this->key) . "." . $this->root["displayarrt"] . " as " . $this->root["y"];
                $this->obj->leftJoin(self::ENTITY_SYMBOL . '.' . $this->root["y"], chr(65 + $this->key));
                break;
            default:
                $selecty = self::ENTITY_SYMBOL . '.' . $this->root["y"] . ' as ' . $this->root["y"];
                break;
        }
        $this->obj->select($this->root["op"] . '(' . self::ENTITY_SYMBOL . '.' . $this->root["x"] . ') as x, ' . $selecty)
            ->groupby($this->root["y"]);
        $where = '1 = 1';
        if (isset($settings["axises"][$this->key]["isdeleted"]) && $settings["axises"][$this->key]["isdeleted"]) {

            $where .= " and " . chr(65 + $this->key) . '.deleted = 0';
        }
        $where .= $this->deleteField();
        $this->obj->where($where);
        $this->obj->setMaxResults(200);

    }

    /**
     *
     */
    function executeQuery()
    {
        $obj = $this->obj->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        foreach ($obj as $item) {
            array_push($this->xs, $item["x"]);
            //Build THE REQUEST
            switch ($this->root["ytype"]) {
                case "datetime":
                    $dd = \DateTime::createFromFormat("d-m-Y", $item[$this->root["y"]]);
                    array_push($this->ys, "'" . $dd->format("d-m-Y") . "'");
                    break;
                case "entity":
                    if ($item[$this->root["y"]] == null)
                        array_push($this->ys, "'null'");
                    else
                        array_push($this->ys, "'" . $item[$this->root["y"]] . "'");
                    break;
                default:
                    array_push($this->ys, $item[$this->root["y"]]);
                    break;
            }
        }
    }

    /**
     * Initiate the Result
     * 
     * @param $result
     */
    public function resultQuery(&$result)
    {
        $result[$this->key][0] = join(",", $this->xs);
        $result[$this->key][1] = join(",", $this->ys);
        $result[$this->key]["legend"] = $this->root["legend"];
        $result[$this->key]["type"] = "axises";
    }
    
}