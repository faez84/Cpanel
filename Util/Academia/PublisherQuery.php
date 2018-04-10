<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Util\Academia;

use FOS\UserBundle\Model\User;
use syndex\AcademicBundle\Entity\Publisher;
use syndex\CpanelBundle\Util\AbstractEntity;
use Symfony\Component\HttpFoundation\Request;
use syndex\CpanelBundle\Services\FileService;

/**
 * Class UserQuery
 */
class PublisherQuery extends AbstractEntity
{
    const INITLOGO = "../../assets/global/img/bg.png";
    const INITCOVER = "../../assets/global/img/uEA01-shamra.svg";
    /**
     * ResearchCategoryQuery constructor.
     */
    public function __construct()
    {

        $this->entity = 'syndexAcademicBundle:Publisher';
        $this->cols = array("arabicFullName");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "arabicFullName,الاسم ",
                2 => "englishFullName,اسم باللغة الانكليزية",
                3 => "slug,Slug",
                4 => "website, الموقع الالكتروني",
                5 => "category, الفئة",
                6 => "createdAt,تاريخ الاضافة",
                7 => "lastUpdatedAt,تاريخ آخر تعديل",
                8 => "createdBy,تمت الاضافة بواسطة",
                9 => "lastUpdatedBy,تم التعديل بواسطة",
                10 => "place,المكان",
                11 => "city,المدينة",
                12 => "phone,التلفون",
                13 => "fax,الفاكس",
                14 => "email,الايميل الالكتروني",
                15 => "syrianRanking,الترتيب السوري",
                16 => "numberOfStudents,عدد الطلاب ",
                17 => "globalRanking,الترتيب العالمي ",
                18 => "establishDate,تاريخ التأسيس ",
                19 => "isPrivate,النوع (خاصة؟) ",
                20 => "logo,اللوغو ",
                21 => "coverImage,صورة الخلفية ",

            );
        $this->fileEXCEL = "Publisherlist.xlsx";
        $this->resourceFolder = "Academia/Publishers";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id", "deleted" => true, "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "arabicFullName", "deleted" => true, "addedit" => true, "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "englishFullName", "addedit" => true, "list" => "", "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "slug", "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                4 => array("name" => "website", "addedit" => true, "list" => false, "type" => "text", "search" => "", "position" => "bottom"),
                5 => array("name" => "category", "addedit" => true, "type" => "entity", "list" => true, "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                6 => array("name" => "place", "addedit" => true, "type" => "entity", "list" => true, "search" => "",
                    "position" => "bottom", "displayarrt" => "name"),
                7 => array("name" => "city", "addedit" => true, "type" => "entity", "list" => true, "search" => "",
                    "position" => "bottom", "displayarrt" => "name"),
                8 => array("name" => "description", "addedit" => true, "type" => "text", "list" => "", "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                9 => array("name" => "phone", "addedit" => true, "type" => "text", "list" => "", "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                10 => array("name" => "fax", "addedit" => true, "type" => "text", "list" => "", "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                11 => array("name" => "email", "addedit" => true, "type" => "text", "list" => "", "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                12 => array("name" => "syrianRanking", "addedit" => true, "type" => "text", "list" => "", "search" => "", "position" => "bottom", "displayarrt" => "arabicFullName"),
                13 => array("name" => "createdAt", "list" => "", "type" => "date", "search" => "", "position" => "top"),
                14 => array("name" => "lastUpdatedAt", "list" => true, "type" => "date", "search" => "", "position" => "top"),
                15 => array("name" => "createdBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                16 => array("name" => "lastUpdatedBy", "list" => "", "type" => "entity", "search" => "", "position" => "bottom", "displayarrt" => "username"),
                17 => array("name" => "additionalInfo", "addedit" => true, "list" => "", "type" => "entity", "search" => "", "subtype" => "one2oneentity"
                , "uppertype" => " "
                , "childs" => array(
                        0 => array("name" => "numberOfStudents", "type" => "text"),
                        1 => array("name" => "globalRanking", "type" => "text"),
                        2 => array("name" => "establishDate", "type" => "date"),
                        3 => array("name" => "isPrivate", "type" => "boolean"),
                        4 => array("name" => "logo", "type" => "file", "subtype" => "image"),
                        5 => array("name" => "coverImage", "type" => "file", "subtype" => "image"),
                    )

                ),
            );
        $this->settings = array(
            "add" => true,
            "edit" => true,
            "delete" => true,
            "entname" => "publisher",
            "section" => "Academia",
            "embededType" => true
        );

        $this->routs = array("list" => 'syndex_acedemia_publishers_admin_list', "show" => 'syndex_cpanel_academia_publisher_show'
        , "delete" => 'syndex_cpanel_academia_publisher_deleted', "exportxsl" => 'syndex_cpanel_publisher_exportxsl',
            "add" => 'syndex_cpanel_publisher_add',
            "edit" => 'syndex_cpanel_publisher_edit',
            "listdeleted" => 'syndex_acedemia_publishers_admin_listdeleted');
        $this->form = "cpanel_academia_publisher_type";
        $this->object = new Publisher();
        $this->role = "ROLE_SONATA_ADMIN_ACADEMIA";
        $this->customView = array("subedit" => true, "subshow" => true);

    }

    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {
        $query = "";

        if (!empty($_SESSION[$args[0]])) {
            $query .= " AND (u.arabicFullName like '%" . $_SESSION[$args[0]] . "%')";
        }

        return $query;
    }

    public function preInsert(FileService $pupService, Request $request)
    {

        if($this->object->getAdditionalInfo()->getEstablishDate()!= null)
            $this->object->getAdditionalInfo()->setEstablishDate($this->object->getAdditionalInfo()->getEstablishDate());
        if ($this->object->getAdditionalInfo()->getLogo() != null) {
            $filename = $pupService->uploadFile($this->object->getAdditionalInfo()->getLogo());
            $this->object->getAdditionalInfo()->setLogo($filename);
        }

        if ($this->object->getAdditionalInfo()->getCoverImage() != null) {
            $filename = $pupService->uploadFile($this->object->getAdditionalInfo()->getCoverImage());
            $this->object->getAdditionalInfo()->setCoverImage($filename);
        }

    }

    public function insert(User $user)
    {

        if ($this->object->getAdditionalInfo()->getLogo() == null)
            $this->object->getAdditionalInfo()->setLogo(self::INITLOGO);
        if ($this->object->getAdditionalInfo()->getCoverImage() == null)
            $this->object->getAdditionalInfo()->setCoverImage(self::INITCOVER);

        $this->object->setCreatedBy($user);
        $this->object->setCreatedAt(new \DateTime('now'));

    }

    public function initUpdate()
    {
        $imageFields = [];
        if($this->object->getAdditionalInfo() != null) {
            $imageFields[0]["name"] = "logo_path";
            $imageFields[0]["value"] = $this->object->getAdditionalInfo()->getLogo();
            $this->object->getAdditionalInfo()->setLogo(null);
            $imageFields[1]["name"] = "cover_path";
            $imageFields[1]["value"] = $this->object->getAdditionalInfo()->getCoverImage();
            $this->object->getAdditionalInfo()->setCoverImage(null);
        }
        else{
            $imageFields[0]["name"] = "logo_path";
            $imageFields[0]["value"] = self::INITLOGO;
            $imageFields[1]["name"] = "cover_path";
            $imageFields[1]["value"] = self::INITCOVER;
        }
        return $imageFields;
    }
    public function preUpdate(FileService $pupService, Request $request)
    {
        if ($this->object->getAdditionalInfo()->getLogo() == null) {
            $this->object->getAdditionalInfo()->setLogo($request->request->get('logo_path'));
        } else {
            $filename = $pupService->uploadFile($this->object->getAdditionalInfo()->getLogo());
            $this->object->getAdditionalInfo()->setLogo($filename);
            if($request->request->get('logo_path') != self::INITLOGO) {
                $pupService->removeFile($request->request->get('logo_path'));
            }

        }

        if ($this->object->getAdditionalInfo()->getCoverImage() == null) {
            $this->object->getAdditionalInfo()->setCoverImage($request->request->get('cover_path'));

        } else {
            $filename = $pupService->uploadFile($this->object->getAdditionalInfo()->getCoverImage());
            $this->object->getAdditionalInfo()->setCoverImage($filename);
            if($request->request->get('cover_path') != self::INITCOVER) {
                $pupService->removeFile($request->request->get('cover_path'));
            }

        }
    }

    public function update(User $user)
    {
        $this->object->setLastUpdatedBy($user);
        $this->object->setLastUpdatedAt(new \DateTime('now'));
    }
 
    public function deleteImgs(FileService $pupService, Request $request)
    {
        $img = $request->request->get('img');
        $fld = $request->request->get('fld');
        $pupService->removeFile($img);
        switch ($fld) {
            case "logo":
                $this->object->getAdditionalInfo()->setLogo(self::INITLOGO);
                break;
            case "coverimage":
                $this->object->getAdditionalInfo()->setCoverImage(self::INITCOVER);
                break;
        }
    }
    public  function CheckValidation($form){
        $validationArr = [];
        $validationArr["globalRanking"] = null;
        $validationArr["numberOfStudents"] = null ;
//        $form->getData()->getArabicFullName()
        $validationArr["valid"] = true;
        if($form->getData()->getAdditionalInfo()->getGlobalRanking()<0 ){
            $validationArr["globalRanking"] ="الرجاء إدخال قيمة أكبر من الصفر";
            $validationArr["valid"] = false;
        }
        if($form->getData()->getAdditionalInfo()->getNumberOfStudents()<0 ){
            $validationArr["numberOfStudents"] ="الرجاء إدخال قيمة أكبر من الصفر";
            $validationArr["valid"] = false;
        }

        return $validationArr;
    }
}