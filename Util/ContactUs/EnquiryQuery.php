<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 1:07 AM
 */

namespace syndex\CpanelBundle\Util\ContactUs;

use FOS\UserBundle\Model\User;
use syndex\ContactUsBundle\Entity\Enquiry;
use syndex\CpanelBundle\Util\AbstractEntity;

/**
 * Class UserQuery
 */
class EnquiryQuery extends AbstractEntity
{

    private $mailer;
    /**
     * ResearchCategoryQuery constructor.
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->entity = 'syndexContactUsBundle:Enquiry';
        $this->cols = array("name", "opcomap", "sentAt", "seen", "replied");

        $this->fileds =
            array(
                0 => "id,id",
                1 => "name,الاسم ",
                2 => "email,الايميل",
                3 => "subject,العنوان",
                4 => "body,نص الرسالة",
                5 => "sentAt,تاريخ الارسال",
                6 => "seen,تمت المشاهدة",
                7 => "reply,الرد",
                8 => "repliedAt,تاريخ الرد",
                9 => "replied,تم الرد",

            );
        $this->fileEXCEL = "contactuslist.xlsx";
        $this->resourceFolder = "Academia/ResearchCategory";
        $this->resourceFolder = "Enquiry";
        $this->defaultSort = "id";
        $this->listfileds =
            array(
                0 => array("name" => "id",  "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                1 => array("name" => "name", "list" => true, "type" => "text", "search" => true, "position" => "bottom"),
                2 => array("name" => "email", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                3 => array("name" => "subject", "list" => true, "type" => "text", "search" => "", "position" => "bottom"),
                4 => array("name" => "body", "list" => "", "type" => "text", "search" => "", "position" => "top"),
                5 => array("name" => "sentAt", "list" => true, "type" => "date", "search" => true, "position" => "top"),
                6 => array("name" => "seen", "list" => true, "type" => "boolean", "search" => true,),
                7 => array("name" => "reply", "inedit" => true, "list" => "", "type" => "text", "search" => ""),
                8 => array("name" => "repliedAt", "list" => "", "type" => "date", "search" => ""),
                9 => array("name" => "replied", "list" => true, "type" => "boolean", "search" => true,),
            );
        $this->settings = array(
            "add" => false,
            "edit" => false,
            "delete" => false,
            "entname" => "enquiry",
            "inedit" => true,
            "changeInShow" => true,
            "section" => "contactus"
        );
        $this->role = "ROLE_SONATA_ADMIN_CONTACTUS";
        $this->object = new Enquiry();
        $this->customView = array("list" => true, "show" => true);
    }

    /**
     * @param $args
     * @return string
     */
    public static function makeQuery($args)
    {

        $query = "";

        if (!empty($_SESSION[$args[0]])) {
            $query .= " AND (u.name like '%".$_SESSION[$args[0]]."%')";
        }
        if (!empty($_SESSION[$args[1]])) {
            $query .= " AND (u.sentAt ".$_SESSION[$args[1]]." '".$_SESSION[$args[2]]."')";
        }
        if (!empty($_SESSION[$args[3]])) {
            $query .= " AND (u.seen = '".($_SESSION[$args[3]]-1)."')";
        }
        if (!empty($_SESSION[$args[4]])) {
            $query .= " AND (u.replied = '".($_SESSION[$args[4]]-1)."')";
        }

        return $query;
    }

    /**
     * @param $fileds
     */
    public function inEdit($fileds){
        $reply = "";
        foreach ($fileds as $filed){
            $reply = $filed["value"];
          $this->object->setReply($filed["value"]);
        }
        $message = \Swift_Message::newInstance()
            ->setSubject('شكراً لك على تواصلك مع محرك البحث السوري شمرا')
            ->setFrom('no-reply@shamra.sy')
            ->setTo($this->object->getEmail())
            ->setBody($reply);
        $this->mailer->send($message);
        $this->object->setReplied();
        $this->object->setRepliedAt(new \DateTime('now'));
    }
    public function updateSeen($value){
        $this->object->setSeen($value);
    }
}
