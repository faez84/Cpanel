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
class TagQuery extends AbstractEntity
{
    public function __construct()
    {
        $this->entity = 'syndexAcademicBundle:Tag';
        $this->cols = array("context");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "context,الاسم ",
                2 => "slug,Slug",
                3 => "createdAt,تاريخ الاضافة",
                4 => "lastUpdatedAt,تاريخ آخر تعديل",
                5 => "createdBy,تمت الاضافة بواسطة",
                6 => "lastUpdatedBy,تم التعديل بواسطة",
            );
        $this->fileEXCEL = "tagslist.xlsx";
        $this->resourceFolder = "Academia/Tag";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "context", "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "slug", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "createdAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                4 => array("name" => "lastUpdatedAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                5 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                6 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
            );
        $this->settings = array("delete" => false, 
            "entname" => "tag",
            "section" => "Academia");
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
            $query .= " AND (u.context like '%".$_SESSION[$args[0]]."%')";
        }

        return $query;
    }
   
}
