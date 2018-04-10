<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/9/2017
 * Time: 10:54 PM
 */

namespace syndex\CpanelBundle\Model;

use syndex\CpanelBundle\Util\Academia\PublisherQuery;
use syndex\CpanelBundle\Util\Academia\ContributerQuery;
use syndex\CpanelBundle\Util\Academia\ResearchCategoryQuery;
use syndex\CpanelBundle\Util\Academia\TagQuery;
use syndex\CpanelBundle\Util\Academia\FieldQuery;
use syndex\CpanelBundle\Util\Academia\ResearchQuery;
use syndex\CpanelBundle\Util\Academia\FollowersTagsQuery;
use syndex\CpanelBundle\Util\ContactUs\EnquiryQuery;


/**
 * Class HelperClass
 */
class HelperClass
{
    /**
     * @return string
     */
    public static function staticBuildQuery()
    {
        $args = func_get_args();

        switch ($args[0]) {
            case "USER":
                return UserQuery::makeQuery($args[1]);
            case "PLACE":
                return PlaceQuery::makeQuery($args[1]);
            case "HPPLACE":
                return HpPlaceQuery::makeQuery($args[1]);
            case "PLACEOWNER":
                return OwnerPlaceQuery::makeQuery($args[1]);
            case "publisher":
                return PublisherQuery::makeQuery($args[1]);
            case "contributer":
                return ContributerQuery::makeQuery($args[1]);
            case "researchcategory":
                return ResearchCategoryQuery::makeQuery($args[1]);
            case "tag":
                return TagQuery::makeQuery($args[1]);
            case "research":
                return ResearchQuery::makeQuery($args[1]);
            case "field":
                return FieldQuery::makeQuery($args[1]);
            case "followerstags":
                return FollowersTagsQuery::makeQuery($args[1]);
            case "enquiry":
                return EnquiryQuery::makeQuery($args[1]);
            default:
                return "";
        }
    }
    public static function simpleEntity(&$cond, $i, $arr, &$list){

        array_push($cond, ' GROUP_CONCAT( DISTINCT ' . chr(65 + $i) . '.' . $arr["displayarrt"] . ' SEPARATOR \',\') AS ' . $arr["name"] . '');
        if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
            $list->leftJoin('u.' . $arr["name"], chr(65 + $i),
                'WITH', chr(65 + $i) . '.deleted = 0');
        } else {
            $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
        }
    }
    public static function simple2MEntity(&$cond, $i, $arr, &$list){

        array_push($cond, ' GROUP_CONCAT( DISTINCT ' . chr(65 + $i) . '.' . $arr["displayarrt"] . ' SEPARATOR \',\') AS ' . $arr["name"] . '');
        if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
            //     array_push($condextra, chr(65 + $i) . ".deleted = 0");
            $list->leftJoin('u.' . $arr["name"], chr(65 + $i),
                'WITH', chr(65 + $i) . '.deleted = 0');
        } else {
            $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
        }
    }
    public static function one2oneEntity(&$cond, $i, $arr, &$list){

        array_push($cond, ' GROUP_CONCAT( DISTINCT ' . chr(65 + $i) . '.' . $arr["name"] . ' SEPARATOR \',\') AS ' . $arr["name"] . '');
        
    }
    public static function comlexM2MEntity(&$cond, $i, $arr, &$list){
        $condextra = array();
        $list->leftJoin('u.' . $arr["name"], chr(65 + $i));
        array_push($cond, ' GROUP_CONCAT( DISTINCT ' . chr(65 + $i) . chr(65 + $i) . '.' . $arr["displayarrt"] . ' SEPARATOR \',\') AS ' . $arr["name"] . '');
        if (isset($arr["isdeleted"]) && $arr["isdeleted"]) {
            array_push($condextra, chr(65 + $i) . chr(65 + $i) . ".deleted = 0");
            $list->leftJoin(chr(65 + $i) . '.' . $arr["subentity"], chr(65 + $i) . chr(65 + $i),
                'WITH', chr(65 + $i) . chr(65 + $i) . '.deleted = 0');
        } else {
            $list->leftJoin(chr(65 + $i) . '.' . $arr["subentity"], chr(65 + $i) . chr(65 + $i));
        }
    }
    private function buildLeftJoin(){

    }
    private function buildArrayPush(){

        return;
    }
}