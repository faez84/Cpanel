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
class HpPlaceQuery implements QueryInterface
{
    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";

        if (!empty($_SESSION[$args[0][0]])) {
            $query .= " AND (p.name like '%".$_SESSION[$args[0][0]]."%')";
        }

        

        return $query;
    }
}
