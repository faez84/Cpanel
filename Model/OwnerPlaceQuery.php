<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Model;

use syndex\CpanelBundle\Model\QueryInterface;

/**
 * Class UserQuery
 */
class OwnerPlaceQuery implements QueryInterface
{
    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";
if(isset($args[0][0]))
        if (isset($_SESSION[$args[0][0]]) && $_SESSION[$args[0][0]]!=null) {
            $query .= " AND (u.status = ".($_SESSION[$args[0][0]]).")";
        }
        if(isset($args[0][1]))

        if (isset($_SESSION[$args[0][1]]) && $_SESSION[$args[0][1]]!=null) {
            $query .= " AND (p.name like '%".($_SESSION[$args[0][1]])."%')";
        }
        if(isset($args[0][2]))
        if (isset($_SESSION[$args[0][2]]) && $_SESSION[$args[0][2]]!=null) {
            $query .= " AND (uu.username like '%".($_SESSION[$args[0][2]])."%')";
        }


        return $query;
    }
}
