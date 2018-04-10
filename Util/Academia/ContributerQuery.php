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
class ContributerQuery extends AbstractEntity
{
    public function __construct()
    {
        $this->entity = 'syndexAcademicBundle:Contributer';
        $this->cols = array("fullName");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "fullName,الاسم ",
                2 => "slug,Slug",
                3 => "email,البريد الالكتروني",
                4 => "shamraUser, السمتخدم",
                //5 => "followers,المتابعون",
                5 => "createdBy,تمت الاضافة بواسطة",
                6 => "createdAt,تاريخ الاضافة",
                7 => "lastUpdatedBy,تم التعديل بواسطة",
                8 => "lastUpdatedAt,تاريخ آخر تعديل",
                9 => "researches,الأبحاث",

            );
        $this->fileEXCEL = "Contibuterlist.xlsx";
        $this->resourceFolder = "Academia/Contributer";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "fullName", "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "slug", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "email", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                4 => array("name" => "shamraUser", "list" => true, "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                // 5 => array("name" => "followers", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "contributer"),
                5 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                6 => array("name" => "createdAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
                7 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                8 => array("name" => "lastUpdatedAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
                9 => array("name" => "researches", "list" => "", "type" => "entity", "subtype"=>"complexm2mentity", "search" => "",
                    "position" => "bottom","displayarrt" => "arabicFullTitle", "subentity"=>"research","uppertype" => true,
                    "isdeleted"=>true,
                    "sublist" => array(
                        "rout" => "syndex_acedemia_reserches_admin_sublist",
                        "step" => 10,
                        "icon" => "fa fa-graduation-cap"
                    ), ),
            );
        $this->settings = array("delete" => false, 
            "entname" => "contributer",
            "section" => "Academia",
            "relations"=>array(
                "entity"=>"syndexAcademicBundle:Research",
                "rout"=>"syndex_acedemia_reserches_cus_admin_list",
                "fields"=>join(",",array(
                    0=>"id",
                    1=>"arabicFullTitle"
                ))
            ),
            "plainquery" => array(
                0 => array(
                    "orderby" => "sumhits",
                    "query" => "
                    select sum(r.hits) as sumhits, c.fullName, c.id 
                    from syndexAcademicBundle:ResearchesContributersRoles as rc
                    LEFT JOIN rc.research as r  
                    left join rc.contributer as  c
                     group by c.fullName  order by sumhits DESC
                    ",
                    "maxresult" => 10,
                    "title" => "contributer._statstitle",
                    "fields" => array(
                        0 => array("name" => "id", "type" => "number", "_name" => "id"),
                        1 => array("name" => "fullName", "type" => "number", "_name" => "contributer.show"),
                        2 => array("name" => "sumhits", "type" => "number", "_name" => "research.hits"),
                    )
                ),
            ),
        );

        $this->routs = array("list" => 'syndex_acedemia_contributers_admin_list', "show" => 'syndex_cpanel_academia_contributer_show'
        , "delete" => 'syndex_cpanel_academia_publisher_deleted',
            "exportxsl" => 'syndex_cpanel_contributer_exportxsl',
            "sublist" => 'syndex_acedemia_contributers_admin_sublist');
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
            $query .= " AND (u.fullName like '%".$_SESSION[$args[0]]."%')";
        }
        
        return $query;
    }
 

}
