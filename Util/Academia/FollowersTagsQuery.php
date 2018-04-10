<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Util\Academia;

use FOS\UserBundle\Model\User;
use syndex\CpanelBundle\Util\AbstractEntity;

/**
 * Class UserQuery
 */
class FollowersTagsQuery extends AbstractEntity
{
    public function __construct()
    {
        $this->entity = 'syndexAcademicBundle:FollowersTags';
        $this->cols = array("tag");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "tag,tag ",
                2 => "follower,follower",
                3 => "followedAt,followedAtة",
                4 => "cancelledAt,cancelledAt",
                5 => "cancelled,cancelled ",
                
            );
        $this->fileEXCEL = "folowerstagslist.xlsx";
        $this->resourceFolder = "Academia/FollowersTags";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "tag", "list" => true, "type" => "entity", "search" => true, "position" => "bottom",
                    "displayarrt" => "context"),
                2 => array("name" => "follower", "list" => true, "type" => "entity", "search" => "", "position" => "bottom",
                    "displayarrt" => "username"),

                //   1 => array("name" => "tag", "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
               // 2 => array("name" => "follower", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "followedAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                4 => array("name" => "cancelledAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                5 => array("name" => "cancelled", "list" => "", "type" => "boolean", "search" => "", "position" => "bottom"),
                     );
        $this->settings = array("delete" => false, 
            "entname" => "followerstags",
            "section" => "Academia",
            "plainquery" => array(
                0 => array(
                    "orderby" => "sumhits",
                    "query" => "
                    select count(f.id) as followers, t.context, t.id 
                    from syndexAcademicBundle:FollowersTags as ft
                    LEFT JOIN ft.tag as t  
                    left join ft.follower as  f
                     group by t.context  order by followers DESC
                    ",
                    "maxresult" => 10,
                    "title" => "followerstags._statstitle",
                    "fields" => array(
                        0 => array("name" => "id", "type" => "number", "_name" => "id"),
                        1 => array("name" => "context", "type" => "number", "_name" => "followerstags.tag"),
                        2 => array("name" => "followers", "type" => "number", "_name" => "followerstags.followers"),
                    )
                ),
            )
            );
        $this->routs = array("list" => 'syndex_acedemia_tag_admin_list',"show" => 'syndex_cpanel_academia_tag_show'
        ,"delete" => 'syndex_cpanel_academia_researchcat_deleted', "exportxsl" => 'syndex_cpanel_tag_exportxsl');
        $this->role = "ROLE_SONATA_ADMIN_ACADEMIA";

    }
    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {

        $query = "";
        if (!empty($_SESSION[$args[0]])) {
            $query .= " AND (A.context like '%".$_SESSION[$args[0]]."%')";
        }

        return $query;
    }
   
}
