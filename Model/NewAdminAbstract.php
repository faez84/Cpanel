<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/1/2017
 * Time: 11:08 AM
 */
namespace syndex\CpanelBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use syndex\CpanelBundle\Model\HelperClass;
use FOS\RestBundle\View\View;

/**
 * Class AdminAbstract
 */
abstract class NewAdminAbstract extends Controller implements AdminInterface
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
    protected  $cache;

    public function __construct(AdminInterface $object)
    {
        $this->object = $object;
    }

    public function globalRouteAction(Request $request, $action, $page)
    {

     dump($action);
        die;
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return mixed
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm($this->object->form, $this->object->object);
        $response = "";
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $kuh = $this->get('syndex.query_process');
                $this->object->insert($this->getUser());
                $em->persist($this->object->object);
                $em->flush();

                return $this->redirect($this->generateUrl($this->object->routs["list"]));
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
            "entname" => $this->object->settings["entname"]
        ));
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->object->object = $em->getRepository($this->object->entity)->find($id);
        $form = $this->createForm($this->object->form, $this->object->object);
        $response = "";
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->object->update($this->getUser());
                $em->flush();

                return $this->redirect($this->generateUrl($this->object->routs["list"]));
            } else {
                $response = array('code' => 400, 'errors' => $form->getErrors(), 'msg' => 'validation error');
            }
        }
        $view = View::create($response, 200);
        return $this->render('CpanelBundle:Default:addedit.html.twig', array(
            'form' => $form->createView(),
            "type" => "edit",
            "listfileds" => $this->object->listfileds,
            "routs" => $this->object->routs,
            'entity' => $this->object->object,
            "entname" => $this->object->settings["entname"]

        ));

    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request)
    {

        $obj = $this->getDoctrine()->getRepository($this->entity)->findBy(array("id" => $request->request->get('idF')));

        $response = new Response(json_encode($obj));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function newShowAction(Request $request)
    {

        //$q = $this->buildQuery(2, 'u.' . $this->defaultSort, "DESC", "u.id =".$request->request->get('idF') );
        $service = $this->get('syndex.cpanelstats.service');
        $q = $service->buildQuery($this->object->cols, $this->object->settings, $this->object->listfileds, $this->object->entity, 2,
            'u.'.$this->object->defaultSort, "DESC", "u.id =".$request->request->get('idF'));

        $obj = $q->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $pathToFolder = $this->container->getParameter('kernel.root_dir').'/../web/uploads/documents/';

        return $this->render('CpanelBundle:Default:show.html.twig', array(
                'obj' => $obj[0],
                "listfileds" => $this->object->listfileds,
                "entname" => $this->object->settings["entname"],
                "pathToFolder" => $pathToFolder,)
        );
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, $id)
    {
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
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function sublistAction(Request $request, $page)
    {
        $msg = "";
        $page = $request->request->get('page');
        $fieldid = $request->request->get('fileldid');
        $id = $request->request->get('idF');

        $service = $this->get('syndex.cpanelstats.service');
        $res = $service->buildSubListQuery($this->object->cols, $this->object->settings, $this->object->entity,
            $this->object->listfileds[$fieldid], "u.id = ".$id, $page);

        $list = $res
            ->setMaxResults($this->object->listfileds[$fieldid]["sublist"]["step"])
            ->setFirstResult($page)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $attrs["settings"] = $this->object->settings;
        $attrs["routs"] = $this->object->routs;
        $attrs["list"] = $list;
        $attrs["listfileds"] = array(
            0 => array("name" =>"id"),
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
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @return null
     */
    public function addtionalParams()
    {
        $result = array();
        if (isset($this->object->settings["axises"])) {
            $stat = $this->get('syndex.cpanelstats.service');
            $result = $stat->getStatsRes($this->object->settings, $this->object->entity);
        }

        return $result;
    }
    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function newlistAction(Request $request, $page)
    {
        $msg = "";
        $response = new Response();
        $service = $this->get('syndex.cpanelstats.service');
        $list = $service->listConfiguration( $this->object->entity, $this->object->listfileds,
            $this->object->settings, $this->object->defaultSort, $this->object->cols, $request, $page, $msg);

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
        $this->attrs["listfileds"] = $this->object->listfileds;
        $this->attrs["settings"] = $this->object->settings;
        $this->attrs["routs"] = $this->object->routs;

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
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function listDeletedAction(Request $request, $page )
    {
        $msg = "";
        $service = $this->get('syndex.cpanelstats.service');
        $list = $service->listConfiguration( $this->object->entity, $this->object->listfileds,
            $this->object->settings, $this->object->defaultSort, $this->object->cols,$request, $page, $msg, 1);
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
        $this->attrs["listfileds"] = $this->object->listfileds;
        $this->attrs["settings"] = $this->object->settings;
        $this->attrs["routs"] = $this->object->routs;

        return $this->render('CpanelBundle:Default:listdeleted.html.twig', $this->attrs);
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function newexportXslAction(Request $request)
    {

        //$res = $this->buildQuery(0, $_SESSION['sort'], $_SESSION['direction'], null, true);
        $service = $this->get('syndex.cpanelstats.service');
        $res = $service->buildQuery($this->object->cols, $this->object->settings, $this->object->listfileds,
            $this->object->entity,0,  $_SESSION['sort'], $_SESSION['direction'], null, true);

        $list = $res->getQuery()
            ->getResult();
        $pup = $this->get('syndex.cpanelbazar.pup');

        return $pup->exportXSL("E", $list, $this->object->fileds, $this->object->fileEXCEL);
    }


    /**
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function listAction(Request $request, $page )
    {
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
     * @security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function exportXslAction(Request $request)
    {
        $list = $this->getDoctrine()
            ->getRepository($this->entity)
            ->findAllOrderedByNameAdmin($this->cols, $_SESSION['sort'], $_SESSION['direction']);

        $pup = $this->get('syndex.cpanelbazar.pup');

        return $pup->exportXSL("E", $list, $this->fileds, $this->fileEXCEL);
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') ")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository($this->object->entity)->find($request->request->get('idF'));
        if($request->request->get('restore') == "restore")
            $product->setDeleted(0);
        else
            $product->setDeleted(1);
        $em->flush();

        $response = new Response(json_encode("yes"));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}