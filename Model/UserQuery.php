<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Model;

/**
 * Class UserQuery
 */
class UserQuery implements QueryInterface
{
    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";


        if (!empty($_SESSION[$args[0][0]])) {
            $query .= " AND (u.firstName = '".$_SESSION[$args[0][0]]."')";
        }

        if (!empty($_SESSION[$args[0][1]])) {
            $query .= " AND '".$_SESSION[$args[0][1]]."' = u.username ";
        }

        if (!empty($_SESSION[$args[0][2]])) {
//            $createTime1 = $args[0][0][2] . " 23:59:59";
//            $createTime2 = $args[0][0][2] . " 00:00:00";
//
//            $query .= " AND '" . $createTime1 . "' >= p.createTime  AND '" . $createTime2 . "' <= p.createTime";
            $query .= " AND '".$_SESSION[$args[0][2]]."' = u.email ";
        }
//        if (!empty($args[0][0][3])) {
////            $updateTime1 = $args[0][0][3] . " 23:59:59";
////            $updateTime2 = $args[0][0][3] . " 00:00:00";
////
////            $query .= " AND '" . $updateTime1 . "' >= p.updateTime  AND '" . $updateTime2 . "' <= p.updateTime";
//        }

        return $query;
    }
}