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
class ResearchQuery extends AbstractEntity
{
    public function __construct()
    {

        $this->entity = 'syndexAcademicBundle:Research';
        $this->cols = array("arabicFullTitle");
        $this->fileds =
            array(
                0 => "id,id",
                1 => "arabicFullTitle,اسم ",
                2 => "englishFullTitle,الاسم بالانكليزي",
                3 => "publisher,الناشر",
                4 => "textualPublisher,جهة ناشرة أخرى",
                5 => "publicationDate,تاريخ النشر",
                6 => "researchCategory,الفئة",
                7 => "document,الملف",
                8 => "indexed,مفهرس",
                9 => "approved,قبول",
                10 => "hits, المشاهدات",
                11 => "createdAt,تاريخ الاضافة",
                12 => "lastUpdatedAt,تاريخ آخر تعديل",
                13 => "createdBy,تمت الاضافة بواسطة",
                14 => "lastUpdatedBy,تم التعديل بواسطة",
            );
        $this->fileEXCEL = "Researchlist.xlsx";
        $this->resourceFolder = "Academia/Researches";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "deleted" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "arabicFullTitle", "deleted" => true, "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "englishFullTitle", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "arabicAbstract", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                4 => array("name" => "englishAbstract", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                5 => array("name" => "publisher", "deleted" => true, "type" => "entity", "list" => true, "search" => "", "position" => "bottom",
                    "displayarrt" => "arabicFullName"),
                6 => array("name" => "textualPublisher", "list" => false, "type" => "date", "search" => "", "position" => "top"),
                7 => array("name" => "publicationDate", "list" => true, "type" => "date", "search" => "", "position" => "bottom"),
                8 => array("name" => "researchCategory", "list" => true, "type" => "entity", "search" => "", "position" => "bottom",
                    "displayarrt" => "arabicFullName"),
                9 => array("name" => "document", "list" => "", "type" => "file", "search" => "", "position" => "bottom"),
                10 => array("name" => "tags", "list" => "", "type" => "entity", "search" => "", "position" => "bottom",
                    "displayarrt" => "id", "uppertype" => true),
                11 => array("name" => "indexed", "list" => "", "type" => "text", "search" => "", "position" => "bottom"),
                12 => array("name" => "approved", "list" => true, "type" => "boolean", "search" => "", "position" => "bottom"),
                13 => array("name" => "hits", "list" => "true", "type" => "text", "search" => "", "position" => "bottom"),
                14 => array("name" => "createdAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                15 => array("name" => "lastUpdatedAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
                16 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                17 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                18 => array("name" => "researchReferences", "list" => "", "type" => "array", "search" => "", "position" => "bottom"),
                19 => array("name" => "researchContributersRoles", "list" => "", "type" => "entity",
                    "search" => "", "subtype" => "complexm2mentity", "uppertype" => true,
                    "position" => "bottom", "displayarrt" => "fullName", "subentity" => "contributer",
                    "sublist" => array(
                        "rout" => "syndex_acedemia_reserches_admin_sublist",
                        "step" => 10,
                        "icon" => "fa fa-address-book"
                    ),
                ),
                20 => array(
                    "name" => "fields",
                    "list" => "", "type" => "entity",
                    "subtype" => "simplem2mentity",
                    "search" => "",
                    "displayarrt" => "arabicFullName",
                    "uppertype" => true,
                    "entity" => "id",
                    "isdeleted" => true,
                    "sublist" => array(
                        "rout" => "syndex_acedemia_reserches_admin_sublist",
                        "step" => 10,
                        "icon" => "fa fa-expand"

                    ),),
            );
        $this->relations = array();
        $this->settings = array(

            "delete" => true,
            "entname" => "research",
            "section" => "Academia",
            "relations" => array(
                "entity" => "syndexAcademicBundle:Research",),
            "textstats" => array(
                0 => array(
                    "orderby" => "hits",
                    "fields" => array(
                        0 => array("name" => "id", "type" => "number", "_name" => "id"),
                        1 => array("name" => "arabicFullTitle", "type" => "number", "_name" => "research.arabicFullTitle"),
                        2 => array("name" => "hits", "type" => "number", "_name" => "research.hits"),
                    ),
                    "maxresult" => 3,
                    "title" => "research._statstitle5"
                ),
                1 => array(
                    "orderby" => "createdAt",
                    "fields" => array(
                        0 => array("name" => "id", "type" => "number", "_name" => "id"),
                        1 => array("name" => "arabicFullTitle", "type" => "number", "_name" => "research.arabicFullTitle"),
                        2 => array("name" => "createdAt", "type" => "datetime", "_name" => "research.createdAt"),
                    ),
                    "maxresult" => 3,
                    "title" => "research._statstitle6"
                ),

            ),
            "axises" => array(
                0 => array(
                    "x" => "id",
                    "y" => "createdAt",
                    "op" => "count",
                    "xtype" => "number",
                    "ytype" => "datetime",
                    "legend" => array(
                        "title" => "research._statstitle1",
                        "xtitle" => "research.count",
                        "ytitle" => "research.createdAt",),),
                1 => array(
                    "x" => "id",
                    "y" => "fields",
                    "op" => "count",
                    "xtype" => "number",
                    "ytype" => "entity",
                    "isdeleted" => true,
                    "displayarrt" => "arabicFullName",
                    "legend" => array(
                        "title" => "research._statstitle2",
                        "xtitle" => "research.count",
                        "ytitle" => "research.fields",),),

                2 => array(
                    "x" => "id",
                    "y" => "publisher",
                    "op" => "count",
                    "xtype" => "number",
                    "ytype" => "entity",
                    "isdeleted" => true,
                    "displayarrt" => "arabicFullName",
                    "legend" => array(
                        "title" => "research._statstitle3",
                        "xtitle" => "research.count",
                        "ytitle" => "research.publisher",),),
                3 => array(
                    "x" => "id",
                    "y" => "researchCategory",
                    "op" => "count",
                    "xtype" => "number",
                    "ytype" => "entity",
                    "isdeleted" => true,
                    "displayarrt" => "arabicFullName",
                    "legend" => array(
                        "title" => "research._statstitle4",
                        "xtitle" => "research.count",
                        "ytitle" => "research.researchCategory",),),
            ),

        );

        $this->routs = array("list" => 'syndex_acedemia_reserches_admin_list', "show" => 'syndex_cpanel_academia_research_show'
        , "delete" => 'syndex_cpanel_academia_researches_deleted', "exportxsl" => 'syndex_cpanel_researches_exportxsl',
            "approved" => 'syndex_cpanel_research_approved', "listdeleted" => 'syndex_acedemia_reserches_admin_listdeleted',
            "sublist" => 'syndex_acedemia_reserches_admin_sublist');
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
            $query .= " AND (u.arabicFullTitle like '%" . $_SESSION[$args[0]] . "%')";
        }

        return $query;
    }

}
