<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/1/2017
 * Time: 11:08 AM
 */
namespace syndex\CpanelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use syndex\CpanelBundle\Model\HelperClass;
use FOS\RestBundle\View\View;
use syndex\CpanelBundle\Model\AdminInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use syndex\AcademicBundle\Entity\PublisherAdditionalInfo;
use Symfony\Component\Form\FormError;

/**
 * Class AdminAbstract
 */
class NewAdminController extends Controller implements AdminInterface
{
    protected $entity;
    protected $cols;
    protected $attrs;
    protected $fileds;
    protected $listfileds = array();
    protected $fileEXCEL;
    protected $resourceFolder = "Users";
    protected $defaultSort = "createdAt";
    protected $step = 20;
    protected $settings = array();
    protected $routs = array();
    protected $from;
    protected $object;
    protected $relations = array();
    protected $cache;
    protected $role = "ROLE_SUPER_ADMIN";

    public function __construct()
    {
        $this->object = new \stdClass();
        $this->object->role = "ROLE_SUPER_ADMIN";
    }

    /**
     * The Main Action
     *
     * @param Request $request
     * @param $oclass
     * @param $action
     * @param $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function globalRouteAction(Request $request, $oclass, $action, $page)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Get The Goal Object
        $modelCreater = $this->get("syndex.cpanel.modelcreater");
        $this->object = $this->get($modelCreater->getModel($oclass));

        //Return The Action
        switch ($action) {
            case "nlistdelete":
                return $this->listDeletedAction($request, $page);
                break;
            case "nlist":
                return $this->newlistAction($request, $page);
                break;
            case "nadd":
                return $this->addAction($request);
                break;
            case "nshow":
                return $this->newShowAction($request, $request->request->get('idF'), $request->request->get('d'));
                break;
            case "ndelete":
                return $this->delAction($request, $request->request->get('idF'), $request->request->get('restore'));
                break;
            case "nedit":
                return $this->editAction($request, $page);
                break;
            case "inedit":
                return $this->ineditAction($request, $request->request->get('idF'), $request->request->get('hhh'));
                break;
            case "nexport":
                return $this->newexportXslAction($request);
                break;
            case "nstatus":
                return $this->statusAction($request, $request->request->get('idF'),
                    $request->request->get('op'));
                break;
            case "nsublist":
                return $this->sublistAction($request, $page = $request->request->get('page'), $request->request->get('idF'),
                    $status = $request->request->get('fileldid'));
                break;
            case "imgdelete":
                return $this->delImageAction($request, $request->request->get('idF'));
                break;
        }
    }

    /**
     *
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ineditAction(Request $request, $id, $fileds)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $this->object->object = $em->getRepository($this->object->entity)->find($id);

        $this->object->inEdit($fileds);

        $em->flush();
        $response = new Response(json_encode($this->object));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function statusAction(Request $request, $id, $op)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $obj = $this->getDoctrine()->getRepository($this->object->entity)->find($id);

        $obj->setApproved($op);
        $em->flush();
        $msg = "";
        if ($op == 1) {
            $msg = "تمت قبول البحث ";
        } else {
            $msg = "تمت رفض البحث";
        }
        $this->container->get("userbundle.user.notification")->notifyUser($obj->getCreatedBy(), $msg . $obj->getCreatedBy()->getUsername(), "#");
        $queryrepository = $em->getRepository('syndexAPIBundle:UsersGCM');
        $usergcm = $queryrepository->getUser($obj->getCreatedBy()->getUsername());

        //CHECK IF ADDED USER IS REGISTERED IN GCM TABLE
        if (!is_null($usergcm)) {
            $this->container->get("syndex_api.gcm_notify")->sendNotification($usergcm->getGcmId(), " ملكية مكان", $msg . $obj->getCreatedBy()->getUsername(), "PLACEAPPROVE");
        }
        $response = new Response(json_encode($obj));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Add Data Using Form
     *
     * @param Request $request
     * @return mixed
     */
    public function addAction(Request $request)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm($this->object->form, $this->object->object);
        $response = "";
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            //Check Addtional Validation - Espically for Embedded Form
            $valid = true;
            $validationArry = $this->object->CheckValidation($form);

            //Show Custom Validation Messages
            if(!$validationArry["valid"]) {
                if($validationArry["numberOfStudents"]!= null)
                    $form->get('additionalInfo')->get("numberOfStudents")->addError(new FormError($validationArry["numberOfStudents"]));

                if($validationArry["globalRanking"]!= null)
                    $form->get('additionalInfo')->get("globalRanking")->addError(new FormError($validationArry["globalRanking"]));
                $valid = false;
            }
            if ($form->isValid() && $valid) {
                $em = $this->getDoctrine()->getManager();
                $kuh = $this->get('syndex.query_process');

                //Check if There is an Embedded Form
                if (isset($this->object->settings["embededType"])) {

                    //Call File Service
                    $fileService = $this->get('syndex.cpanel.file');
                    //Initiat Insert Method
                    $this->object->preInsert($fileService, $request);
                }
                //Call Insert Method and Persist Data
                $this->object->insert($this->getUser());
                $em->persist($this->object->object);
                $em->flush();

                return $this->redirect($this->generateUrl('syndex_cpanel_globalroutes',
                    array('section' => $this->object->settings["section"], "oclass" => $this->object->settings["entname"], "action" => "nlist")));
            } else {
                $response = array('code' => 400, 'errors' => $form->getErrors(), 'msg' => 'validation error');
            }
        }
        $view = View::create($response, 200);

        return $this->render('CpanelBundle:Default:addedit.html.twig', array(
            'form' => $form->createView(),
            "type" => "add",
            "listfileds" => $this->object->listfileds,
            "routs" => $this->object->routs,
            "entname" => $this->object->settings["entname"],
            "section" => $this->object->settings["section"]

        ));
    }

    /**
     * Edit Data Using Form
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        //Get the Object
        $em = $this->getDoctrine()->getManager();
        $this->object->object = $em->getRepository($this->object->entity)->find($id);

        //Init an Array To Store Images Attributes
        $imageFields = [];

        //Check If The Form Contains Embede Type 
        if (isset($this->object->settings["embededType"])) {

            //Get Image Fields From The Entity
            $imageFields = $this->object->initUpdate();
        }
        $form = $this->createForm($this->object->form, $this->object->object);
        $response = "";
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            //Check Additional Validation - Espically for Embedded Form
            $valid = true;
            $validationArry = $this->object->CheckValidation($form);

            //Show Custom Validation Messages
            if(!$validationArry["valid"]) {
                if($validationArry["numberOfStudents"]!= null)
                    $form->get('additionalInfo')->get("numberOfStudents")->addError(new FormError($validationArry["numberOfStudents"]));

                if($validationArry["globalRanking"]!= null)
                    $form->get('additionalInfo')->get("globalRanking")->addError(new FormError($validationArry["globalRanking"]));
                $valid = false;
            }
            if ($form->isValid() && $valid) {
                //Check if There is an Embedded Form
                if (isset($this->object->settings["embededType"])) {

                    //Csll File Service
                    $fileService = $this->get('syndex.cpanel.file');
                    //Initiat Update Method
                    $this->object->preUpdate($fileService, $request);
                }
                //Update Data
                $this->object->update($this->getUser());
                $em->flush();

                return $this->redirect($this->generateUrl('syndex_cpanel_globalroutes',
                    array('section' => $this->object->settings["section"], "oclass" => $this->object->settings["entname"], "action" => "nlist")));
            } else {
                $response = array('code' => 400, 'errors' => $form->getErrors(), 'msg' => 'validation error');
            }
        }
        $view = View::create($response, 200);

        //Define a Variable for Extended Edit Page
        $subedit = false;
        //Check if there is an Extended Edit Page
        if (isset($this->object->customView["subedit"])) {
            $subedit = $this->object->customView["subedit"];
        }
        return $this->render('CpanelBundle:Default:addedit.html.twig', array(
            'form' => $form->createView(),
            "type" => "edit",
            "listfileds" => $this->object->listfileds,
            "routs" => $this->object->routs,
            'entity' => $this->object->object,
            "entname" => $this->object->settings["entname"],
            "section" => $this->object->settings["section"],
            'imageFields' => $imageFields,
            'idd' => $id,
            'subedit' => $subedit
        ));

    }

    /**
     * Show Data JSON Format
     *
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        $obj = $this->getDoctrine()->getRepository($this->entity)->findBy(array("id" => $request->request->get('idF')));
        $response = new Response(json_encode($obj));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * New Show Action- Normal Format
     *
     * @param Request $request
     * @return Response
     */
    public function newShowAction(Request $request, $id, $d)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Call Query Service
        $service = $this->get('syndex.cpanelstats.service');
        //BUild The Query
        $q = $service->buildQuery($this->object->cols, $this->object->settings, $this->object->listfileds, $this->object->entity, $d,
            'u.' . $this->object->defaultSort, "DESC", "u.id =" . $id, true);
        //Execute the Query
        $obj = $q->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $pathToFolder = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/web/uploads/documents/";
        $pathToFolder2 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/web/assets/global/img/";
        //Init an Array To Store Images Attributes
        $imageFields = [];

        //Check If The Form Contains Embede Type
        if (isset($this->object->settings["embededType"])) {
            $em = $this->getDoctrine()->getManager();
            $this->object->object = $em->getRepository($this->object->entity)->find($id);

            //Get Image Fields From The Entity
            $imageFields = $this->object->initUpdate();
        }
        $inedit = false;
        if (isset($this->object->settings["inedit"]))
            $inedit = $this->object->settings["inedit"];
        if (isset($this->object->settings["changeInShow"])) {
            $em = $this->getDoctrine()->getManager();
            $obj2 = $this->getDoctrine()->getRepository($this->object->entity)->find($id);
            $obj2->setSeen(1);
            $em->flush();
        }

        return $this->render('CpanelBundle:Default:show.html.twig', array(
                'obj' => $obj[0],
                "listfileds" => $this->object->listfileds,
                "entname" => $this->object->settings["entname"],
                "section" => $this->object->settings["section"],
                "pathToFolder" => $pathToFolder,
                "pathToFolder2" => $pathToFolder2,
                "inedit" => $inedit,
                'imageFields' => $imageFields,
                'sublist' => $this->object->customView["subshow"]
            )
        );
    }

    /**
     * Delete Action
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, $id)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository($this->entity)->find($id);
        $product->setDeleted(1);
        $em->flush();
        $request->getSession()->getFlashBag()->add(
            'notice',
            'Delete is done.'
        );

        return $this->redirect($this->generateUrl('syndex_bazar_admin_product_list'));
    }


    /**
     * List Child Items in Many to Many and Many to One Relation
     *
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function sublistAction(Request $request, $page, $id, $fieldid)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        //Call Query Service
        $service = $this->get('syndex.cpanelstats.service');
        //Build Thhe Query
        $res = $service->buildSubListQuery($this->object->cols, $this->object->settings, $this->object->entity,
            $this->object->listfileds[$fieldid], "u.id = " . $id, $page);
        //Get The Result
        $list = $res
            ->setMaxResults($this->object->listfileds[$fieldid]["sublist"]["step"])
            ->setFirstResult($page)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $attrs["settings"] = $this->object->settings;
        $attrs["routs"] = $this->object->routs;
        $attrs["list"] = $list;
        $attrs["listfileds"] = array(
            0 => array("name" => "id"),
            1 => array("name" => $this->object->listfileds[$fieldid]["name"]),
        );
        $attrs["step"] = $this->object->listfileds[$fieldid]["sublist"]["step"];
        $attrs["fieldid"] = $fieldid;
        $attrs["id"] = $id;
        $attrs["page"] = $page;
        $attrs["entname"] = $this->object->settings["entname"];

        return $this->render('CpanelBundle:Default:sublist.html.twig', $attrs);
    }

    /**
     * Statistics Action
     *
     * @return null
     */
    public function addtionalParams()
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $result = array();
        if (isset($this->object->settings["axises"]) || isset($this->object->settings["plainquery"])) {
            $stat = $this->get('syndex.cpanelstats.service');
            $result = $stat->getStatsRes($this->object->settings, $this->object->entity);
        }

        return $result;
    }

    /**
     * List Action
     *
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function newlistAction(Request $request, $page, $msg = "")
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //CAll Query Service
        $service = $this->get('syndex.cpanelstats.service');
        //Build The Query and Execute It
        $list = $service->listConfiguration($this->object->entity, $this->object->listfileds,
            $this->object->settings, $this->object->defaultSort, $this->object->cols, $request, $page, $msg);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page/* page number */,
            self::ITEMS_COUNT/* limit per page */
        );

        //Assign Values
        $this->attrs['pagination'] = $pagination;
        $this->attrs["op"] = $_SESSION['op'];
        $this->attrs["params"] = $this->AddtionalParams();
        $this->attrs["msg"] = $msg;
        $this->attrs["listfileds"] = $this->object->listfileds;
        $this->attrs["settings"] = $this->object->settings;
        $this->attrs["routs"] = $this->object->routs;

        $response = new Response();
        if (isset($this->object->customView["list"])) {
            $response = $this->render('CpanelBundle:' . $this->object->resourceFolder . ':list.html.twig', $this->attrs);
        } else
            $response = $this->render('CpanelBundle:Default:list.html.twig', $this->attrs);
//        $response->setPublic();
//        $response->setMaxAge(500);
//        $date = new \DateTime();
//        $date->modify('+600 seconds');
//        $response->setExpires($date);
//        $response->setETag(md5($response->getContent()));
        return $response;
    }

    /**
     * List Deleted Items
     *
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function listDeletedAction(Request $request, $page, $msg = "")
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Call Query Service
        $service = $this->get('syndex.cpanelstats.service');
        //Build and Execute the Query
        $list = $service->listConfiguration($this->object->entity, $this->object->listfileds,
            $this->object->settings, $this->object->defaultSort, $this->object->cols, $request, $page, $msg, 1);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page/* page number */,
            self::ITEMS_COUNT/* limit per page */
        );
        //Assign The Values
        $this->attrs['pagination'] = $pagination;
        $this->attrs["op"] = $_SESSION['op'];
        $this->attrs["params"] = $this->AddtionalParams();
        $this->attrs["msg"] = $msg;
        $this->attrs["listfileds"] = $this->object->listfileds;
        $this->attrs["settings"] = $this->object->settings;
        $this->attrs["routs"] = $this->object->routs;

        return $this->render('CpanelBundle:Default:listdeleted.html.twig', $this->attrs);
    }

    /**
     * New Export Action
     *
     * @param Request $request
     * @return Response
     */
    public function newexportXslAction(Request $request)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Call Query Service
        $service = $this->get('syndex.cpanelstats.service');
        //Build Te Query
        $res = $service->buildQuery($this->object->cols, $this->object->settings, $this->object->listfileds,
            $this->object->entity, 0, $_SESSION['sort'], $_SESSION['direction'], null, true);
        //Execute the Query
        $list = $res->getQuery()
            ->getResult();
        //Call Public Service
        $pup = $this->get('syndex.cpanelbazar.pup');

        return $pup->exportXSL("E", $list, $this->object->fileds, $this->object->fileEXCEL);
    }

    /**
     * Old List Action
     *
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function listAction(Request $request, $page )
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        $msg = "";

        $rescols = [];

        array_map(array($this, "callback"), $this->cols);
        $_SESSION['op'] = $request->request->get('op');

        $direction = $request->query->get('direction');

        if (!$direction) {
            $direction = 'DESC';
        }

        $sort = $request->query->get('sort');
        $sort = str_replace("[", $sort = str_replace("]", $sort, ""), "");

        if (!$sort) {
            $sort = 'u.' . $this->defaultSort;
        } else {
            if (($sort != "cpr") && ($sort != "cityName") && ($sort != "categoryName") && ($sort != "storeName"))
                $sort = 'u.' . $sort;
        }

        foreach ($this->cols as $col) {
            if ($request->request->get($col) != "") {
                $_SESSION[$col] = $request->request->get($col);
            }
        }
        $list = $this->getDoctrine()
            ->getRepository($this->entity)
            ->findAllOrderedByNameAdmin($this->cols, $sort, $direction);
        $_SESSION['direction'] = $direction;
        $_SESSION['sort'] = $sort;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page/* page number */,
            self::ITEMS_COUNT/* limit per page */
        );
        $this->attrs['pagination'] = $pagination;
        $this->attrs["op"] = $_SESSION['op'];
        $this->attrs["params"] = $this->AddtionalParams();
        $this->attrs["msg"] = $msg;
        $this->attrs["listfileds"] = $this->listfileds;
        $this->attrs["settings"] = $this->settings;
        $this->attrs["routs"] = $this->routs;

        return $this->render('CpanelBundle:' . $this->resourceFolder . ':list.html.twig', $this->attrs);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function exportXslAction(Request $request)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }

        $list = $this->getDoctrine()
            ->getRepository($this->entity)
            ->findAllOrderedByNameAdmin($this->cols, $_SESSION['sort'], $_SESSION['direction']);

        $pup = $this->get('syndex.cpanelbazar.pup');

        return $pup->exportXSL("E", $list, $this->fileds, $this->fileEXCEL);
    }

    /**
     * Delete Action
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delAction(Request $request, $id, $restore)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Get the Object
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository($this->object->entity)->find($id);
        //Check Type of Operation if(Delete or UnDelete)
        if ($restore == "restore")
            $product->setDeleted(0);
        else
            $product->setDeleted(1);
        $em->flush();

        $response = new Response(json_encode("yes"));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Delete Image Action
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delImageAction(Request $request, $id)
    {
        //Check The Security Level
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')
            && !$this->get('security.authorization_checker')->isGranted($this->object->role)
        ) {
            throw new AccessDeniedException();
        }
        //Get The Object
        $em = $this->getDoctrine()->getManager();
        $this->object->object = $em->getRepository($this->object->entity)->find($id);
        //Call File Service
        $fileService = $this->get('syndex.cpanel.file');
        //Deelte the File
        $this->object->deleteImgs($fileService, $request);
        $em->flush();

        $response = new Response(json_encode("yes"));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}