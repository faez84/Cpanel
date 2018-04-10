<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Model;
use FOS\UserBundle\Model\User;
use syndex\AcademicBundle\Entity\Field;

/**
 * Class UserQuery
 */
class FieldQuery extends AbstractEntity
{
    /**
     * ResearchCategoryQuery constructor.
     */
    public function __construct()
    {
        $this->entity = 'syndexAcademicBundle:Field';
        $this->cols = array("arabicFullName");
        $this->fileds =
            array(
                0 => "id,id",
                1 => "arabicFullName,اسم ",
                2 => "englishFullName,الاسم الانكليزي",
                3 => "parent,المجال الأب",
                4 => "slug,Slug",
                5 => "createdAt,تاريخ الاضافة",
                6 => "lastUpdatedAt,تاريخ آخر تعديل",
                7 => "createdBy,تمت الاضافة بواسطة",
                8 => "lastUpdatedBy,تم التعديل بواسطة",


            );
        $this->fileEXCEL = "Fieldslist.xlsx";
        $this->resourceFolder = "Academia/Field";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "deleted" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "arabicFullName", "deleted" => true,"addedit" => true, "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "englishFullName","addedit" => true, "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
//                3 => array("name" => "children", "list" => false, "type" => "entity", "search" => "", "position" => "bottom",
//                    "displayarrt" => "arabicFullName", "uppertype" => true),
            3 => array("name" => "parent","addedit" => true, "list" => true,
                "type" => "entity", "search" => "", "position" => "bottom",
                "displayarrt" => "arabicFullName",  "isdeleted" => true),
            4 => array("name" => "slug", "type" => "text", "list" => false, "search" => "", "position" => "bottom"),
            5 => array("name" => "createdAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
            6 => array("name" => "lastUpdatedAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
            7 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
            8 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
        );
        $this->settings = array(
            "add" => true,
            "edit" => true,
            "delete" => true, "entname" => "field");

        $this->routs = array("list" => 'syndex_acedemia_field_admin_list',"show" => 'syndex_cpanel_academia_field_show'
        ,"delete" => 'syndex_cpanel_academia_field_deleted', "exportxsl" => 'syndex_cpanel_field_exportxsl'
        , "add" => 'syndex_cpanel_field_add', "edit" => 'syndex_cpanel_field_edit',
            "listdeleted" => 'syndex_acedemia_field_admin_listdeleted'
        );
        $this->form = "cpanel_academia_field_type";
        $this->object = new Field();

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
