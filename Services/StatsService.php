<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:47 م
 */

namespace syndex\CpanelBundle\Services;


use Doctrine\Common\Persistence\ObjectManager;

;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\Expr\Join;
use syndex\CpanelBundle\Model\HelperClass;
use syndex\CpanelBundle\Util\EntityQuery;
use syndex\CpanelBundle\Util\Statis\MakerStatis;


/**
 * Class StatsService
 * @package syndex\CpanelBundle\Services
 */
class StatsService
{
    const ENTITY_SYMBOL = "u";
    const SIMPLEM2M = "simplem2mentity";
    const COMPLEXM2M = "complexm2mentity";
    const ONE2ONE = "one2oneentity";

    /**
     * The Object Manager
     *
     * @var ObjectManager
     */
    protected $em;

    /**
     * StatsService constructor.
     *
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * CallBack Function To Initiat Values of Sessions
     *
     * @param $item
     * @return string
     */
    public function callback($item)
    {
        return $_SESSION[$item] = "";
    }

    /**
     * Build And Execute Teh Query
     *
     * @param Request $request
     * @param $page
     * @param string $msg
     * @return mixed
     */
    public function listConfiguration($entity, $listfileds, $settings, $defaultSort, $cols, Request $request, $page, $msg = "", $d = 0)
    {
        //Calback Function
        array_map(array($this, "callback"), $cols);
        //get the Operation
        $_SESSION['op'] = $request->request->get('op');
        //Get the order
        $direction = $request->query->get('direction');
        if (!$direction) {
            $direction = 'DESC';
        }
        //Get the Sort Parameter
        $sort = $request->query->get('sort');
        $sort = str_replace("[", $sort = str_replace("]", $sort, ""), "");
        if (!$sort) {
            $sort = 'u.' . $defaultSort;
        } else {
            if (($sort != "cpr") && ($sort != "cityName") && ($sort != "categoryName") && ($sort != "storeName"))
                $sort = 'u.' . $sort;
        }

        foreach ($cols as $col) {
            if ($request->request->get($col) != "") {

                $_SESSION[$col] = $request->request->get($col);
            }
        }
        //Build the Query
        $res = $this->buildQuery($cols, $settings, $listfileds, $entity, $d, $sort, $direction);
        //Execute the Query
        $list = $res->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //Assign the values
        $_SESSION['direction'] = $direction;
        $_SESSION['sort'] = $sort;

        return $list;
    }

    /**
     * Build The Statistics Page
     *
     * @param $settings
     * @param $entity
     * @return mixed
     */
    public function getStatsRes($settings, $entity)
    {
        $result = [];
        $makerStatis =new MakerStatis($this->em, $settings, $entity, $result);

        if(isset($settings["axises"])) {
            $makerStatis->executeAxisesStatis();
        }
        if(isset($settings["textstats"])) {
            $makerStatis->executeTextStatis();
        }
        if(isset($settings["plainquery"])) {
            $makerStatis->executeQueryStatis();
        }

        return $result;
    }

    /**
     * @param $sort
     * @param $direction
     * @return mixed
     */
    public function buildSubListQuery($cols, $settings, $entity, $arr, $globcond)
    {
        $list = $this->em->getRepository($entity)
            ->createQueryBuilder('u');

        $cond = array();
        $m2m = array();
        $i = 0;
        $condextra = array();
        switch ($arr["type"]) {
            case "entity":
                if (!isset($arr["uppertype"])) {
                    array_push($cond, chr(65 + $i) . "." . $arr["displayarrt"] . " as " . $arr["name"]);
                    if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
                        //   array_push($condextra, chr(65 + $i) . ".deleted = 0");
                        $list->leftJoin('u.' . $arr["name"], chr(65 + $i),
                            'WITH', chr(65 + $i) . '.deleted = 0');
                    } else {
                        $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
                    }
                } else {
                    if (isset($arr["subtype"])) {
                        if ($arr["subtype"] == "simplem2mentity") {

                            array_push($cond, chr(65 + $i) . '.' . $arr["displayarrt"] . '  AS ' . $arr["name"] . '
                                     , ' . chr(65 + $i) . '.id as id'
                            );
                            if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
                                //   array_push($condextra, chr(65 + $i) . ".deleted = 0");
                                $list->leftJoin('u.' . $arr["name"], chr(65 + $i),
                                    'WITH', chr(65 + $i) . '.deleted = 0');
                            } else {
                                $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
                            }
                        } else {
                            if ($arr["subtype"] == "complexm2mentity") {
                                $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
                                array_push($cond, chr(65 + $i) . chr(65 + $i) . '.' . $arr["displayarrt"] . ' AS ' . $arr["name"] . '
                                        , ' . chr(65 + $i) . chr(65 + $i) . '.id as id');
                                if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
                                    array_push($condextra, chr(65 + $i) . chr(65 + $i) . ".deleted = 0");
                                    $list->leftJoin(chr(65 + $i) . '.' . $arr["subentity"], chr(65 + $i) . chr(65 + $i),
                                        'WITH', chr(65 + $i) . chr(65 + $i) . '.deleted = 0');
                                } else {
                                    $list->leftJoin(chr(65 + $i) . '.' . $arr["subentity"], chr(65 + $i) . chr(65 + $i));
                                }
                            }
                        }
                    }
                }
                $i++;
                break;
            default:
                array_push($cond, " u." . $arr["name"]);
                break;
        }
        $query = HelperClass::staticBuildQuery($settings["entname"], $cols);
        if ($settings["delete"]) {
            $query .= " and u.deleted = 0";
        }
        if ($globcond != null) {
            $query .= " and " . $globcond;
        }
        if (!empty($condextra))
            $query .= " and " . join(" and ", $condextra);
        $list->select(join(", ", $cond))->where('1 = 1' . $query);

        return $list;
    }

    /**
     * Build the Query
     *
     * @param $cols
     * @param $settings
     * @param $listfileds
     * @param $entity
     * @param $d
     * @param $sort
     * @param $direction
     * @param null $globcond
     * @param bool $passprot
     */
    public function buildQuery($cols, $settings, $listfileds, $entity, $d, $sort, $direction, $globcond = null, $passprot = false)
    {
        $cond = array();
        $list = $this->em->getRepository($entity)
            ->createQueryBuilder('u');
        $condextra = array();

        foreach ($listfileds as $key=>$arr) {
            if ($arr["list"] || $passprot) {
                switch ($arr["type"]) {
                    case "entity":
                        if (!isset($arr["uppertype"])) {
                            HelperClass::simple2MEntity($cond, $key, $arr, $list);
                        } else {
                            if (isset($arr["subtype"])) {
                                if ($arr["subtype"] == self::SIMPLEM2M) {
                                    HelperClass::simple2MEntity($cond, $key, $arr, $list);
                                } else {
                                    if ($arr["subtype"] == self::COMPLEXM2M) {
                                        HelperClass::comlexM2MEntity($cond, $key, $arr, $list);
                                    }
                                    else{
                                        if($arr["subtype"] == self::ONE2ONE){
                                            foreach ($arr["childs"] as $kkey=>$subchild) {
                                                HelperClass::one2oneEntity($cond, $key, $subchild, $list);
                                           }
                                            $list->leftJoin('u.' . $arr["name"], chr(65 + $key));
                                        }
                                    }

                                }
                            }
                        }
                        break;
                    case "onetoone":

                        break;

                    default:
                        array_push($cond, self::ENTITY_SYMBOL . ".".$arr["name"]);
                        break;
                }
            }
        }
        $query = HelperClass::staticBuildQuery($settings["entname"], $cols);

        if ($settings["delete"]) {
            if($d == "")
                $d =0;
            $query .= "and ".self::ENTITY_SYMBOL.".deleted = ".$d;
        }

        if ($globcond != null) {
            $query .= " and " . $globcond;
        }

        if (!empty($condextra))
            $query .= " and " . join(" and ", $condextra);
        $list->select(join(", ", $cond))->where('1 = 1' . $query)->addOrderBy($sort, $direction)->groupby("u.id");
        if ($query == "") {
            $list->setMaxResults(1000);
        }

        return $list;
    }
}