<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/1/2017
 * Time: 11:08 AM
 */
namespace syndex\CpanelBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use syndex\CpanelBundle\Model\HelperClass;
use FOS\RestBundle\View\View;

/**
 * Class ModelCreater
 */
class ModelCreater
{
    /**
     * Rerturn the Entity Model
     * 
     * @param $signature
     * @return string
     */
    public function getModel($signature)
    {
        switch ($signature) {
            case "researchcategory" :
                return "syndex.cpanel.researchcategory";
                breake;
            case "research" :
                return "syndex.cpanel.research";
                breake;
            case "field" :
                return "syndex.cpanel.field";
                breake;
            case "publisher" :
                return "syndex.cpanel.publisher";
                breake;
            case "tag" :
                return "syndex.cpanel.tag";
                breake;
            case "contributer" :
                return "syndex.cpanel.contributer";
                breake;
            case "followerstags" :
                return "syndex.cpanel.followerstags";
                breake;
            case "enquiry" :
                return "syndex.cpanel.contactus";
                breake;
        }
    }
}