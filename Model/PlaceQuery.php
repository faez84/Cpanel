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
class PlaceQuery implements QueryInterface
{
    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";

        if (!empty($_SESSION[$args[0][0]])) {
            $query .= " AND (u.name like '%".$_SESSION[$args[0][0]]."%')";
        }

        if (!empty($_SESSION[$args[0][1]])) {
            $query .= " AND '".$_SESSION[$args[0][1]]."' = c.name ";
        }
        if (isset($_SESSION[$args[0][2]]) && $_SESSION[$args[0][2]]!= "") {
            if ($_SESSION[$args[0][2]] > 0) {
                $query .= " AND 0 < u.verified ";
            } else {
                $query .= " AND ".$_SESSION[$args[0][2]]." = u.verified ";
            }
        }
        


        return $query;
    }
}
