<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Util\Academia;

use FOS\UserBundle\Model\User;
use syndex\AcademicBundle\Entity\ResearchCategory;
use syndex\CpanelBundle\Util\AbstractEntity;

/**
 * Class UserQuery
 */
class ResearchCategoryQuery extends AbstractEntity
{


    /**
     * ResearchCategoryQuery constructor.
     */
    public function __construct()
    {

        $this->entity = 'syndexAcademicBundle:ResearchCategory';
        $this->cols = array("arabicFullName");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "arabicFullName,الاسم ",
                2 => "englishFullName,اسم باللغة الانكليزية",
                3 => "slug,Slug",
                4 => "createdAt,تاريخ الاضافة",
                5 => "lastUpdatedAt,تاريخ آخر تعديل",
                6 => "createdBy,تمت الاضافة بواسطة",
                7 => "lastUpdatedBy,تم التعديل بواسطة",

            );
        $this->fileEXCEL = "researchcatlist.xlsx";
        $this->resourceFolder = "Academia/ResearchCategory";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "deleted" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "arabicFullName", "deleted" => true,"addedit" => true, "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "englishFullName","addedit" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "slug", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                4 => array("name" => "createdAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                5 => array("name" => "lastUpdatedAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                6 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                7 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
            );
        $this->settings = array(
            "add" => true,
            "edit" => true,
            "delete" => true,
            "entname" => "researchcategory",
            "section" => "Academia",);

        $this->routs = array("list" => 'syndex_acedemia_researchcat_admin_list',"show" => 'syndex_cpanel_academia_researchcat_show'
        ,"delete" => 'syndex_cpanel_academia_researchcat_deleted', "exportxsl" => 'syndex_cpanel_researchcat_exportxsl'
        , "add" => 'syndex_cpanel_researchcat_add', "edit" => 'syndex_cpanel_researchcat_edit',
            "listdeleted" => 'syndex_acedemia_researchcat_admin_listdeleted');
        $this->form = "cpanel_academia_reserachcat_type";

        $this->role = "ROLE_SONATA_ADMIN_ACADEMIA";

        $this->object = new ResearchCategory();

    }

    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";

        if (!empty($_SESSION[$args[0]])) {
            $query .= " AND (u.arabicFullName like '%".$_SESSION[$args[0]]."%')";
        }

        return $query;
    }
    public function insert(User $user){

        $this->object->setCreatedBy($user);
        $this->object->setCreatedAt(new \DateTime('now'));

    }
    public function update(User $user){

        $this->object->setLastUpdatedBy($user);
        $this->object->setLastUpdatedAt(new \DateTime('now'));

    }
}
