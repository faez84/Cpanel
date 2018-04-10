<?php

namespace syndex\CpanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use syndex\SearchBundle\ElasticSearch\Displayer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use syndex\SearchBundle\ElasticSearch\pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use syndex\AdminBundle\Entity\IndexChoices;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CpanelBundle:Default:index.html.twig');
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @param $page
     * @return Response
     */
    public function listAction(Request $request, $page)
    {
        if ($request->request->get('op') == "op") {
            $_SESSION['op'] = $request->request->get('op');
        }

        if ($request->query->get('op') == "cal") {
            $_SESSION['op'] = $request->query->get('op');
            $_SESSION['ct'] = "";
            $_SESSION['status'] = "";
            $_SESSION['type'] = "";
            $_SESSION['reference'] = "";
            $_SESSION['rank'] = "";
            $_SESSION['ut'] = "";
        }

        $sort = $request->query->get('sort');
        $sort = str_replace("[",$sort=str_replace("]",$sort,""),"");
        if (!$sort) {
            $sort = 'd.createTime';
        } elseif ($sort == "hits") {
            $sort = 'n.' . $sort;
        } else {
            $sort = 'd.' . $sort;
        }

        $direction = $request->query->get('direction');
        if (!$direction) {
            $direction = 'DESC';
        }
        $_SESSION['direction'] = $direction;
        $_SESSION['sort'] = $sort;

        if ($request->request->get('createTime') != "") {
            $_SESSION['ct'] = $request->request->get('createTime');
        }

        if ($request->request->get('updateTime') != "") {
            $_SESSION['ut'] = $request->request->get('updateTime');
        }
        if ($request->request->get('status') != "") {
            $_SESSION['status'] = $request->request->get('status');
        }
        if ($request->request->get('type') != "") {
            $_SESSION['type'] = $request->request->get('type');
        }
        if ($request->request->get('reference') != "") {
            $_SESSION['reference'] = $request->request->get('reference');
        }
        if ($request->request->get('rank') != "") {
            $_SESSION['rank'] = $request->request->get('rank');
        }
        $list = $this->getDoctrine()
            ->getRepository('syndexAdminBundle:IndexChoices')
            ->findAllOrderedByNameAdmin(
                $_SESSION['type'],
                $_SESSION['reference'],
                $_SESSION['rank'],
                $_SESSION['status'],
                $_SESSION['ct'],
                $_SESSION['ut'],
                $sort,
                $direction
            );


        if (!$list) {
        }
        $cats = $this->getDoctrine()
            ->getRepository('syndexAdminBundle:IndexChoices')
            ->findAllDisType();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page/* page number */,
            20/* limit per page */
        );

        return $this->render('CpanelBundle:AutoEmails:list.html.twig', array('pagination' => $pagination, 'cats' => $cats
        , 'op' => $_SESSION['op']));
    }
    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_BAZAR')")
     * @param Request $request
     * @return Response
     */
    public function exportXslAction(Request $request)
    {
        $list = $this->getDoctrine()
            ->getRepository('syndexAdminBundle:IndexChoices')
            ->findAllAdmin(
                $_SESSION['type'],
                $_SESSION['reference'],
                $_SESSION['rank'],
                $_SESSION['status'],
                $_SESSION['ct'],
                $_SESSION['ut'],
                $_SESSION['sort'],
                $_SESSION['direction']
            );
        $pup = $this->get('syndex.cpanelbazar.pup');
        $filed=array(0=>"id,id",1=>"title,الخبر", 2=>"hits,المشاهدات",3=>"status,الحالة", 4=>"createTime,اتاريخ الانشاء",
            5=>"updateTime,تاريخ التعديل"

        );

        return $pup->exportXSL("E", $list, $filed, "chosennews.xlsx");
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addIndexChoicesAction(Request $request)
    {
        $indexchoices = new IndexChoices();
        $form = $this->createForm('index_choices', $indexchoices);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $indexchoices->setRank(0);
                $indexchoices->setType("news");
                $indexchoices->setCreateTime(new \DateTime('now'));
                $indexchoices->setUpdateTime(new \DateTime('now'));
                $indexchoices->setUpdateBy($this->getUser());
                $indexchoices->setCreateBy($this->getUser());


                $em->persist($indexchoices);
                $em->flush();
                return $this->redirect($this->generateUrl('syndex_cpanel_indexchoices_list'));
            }
        }
        return $this->render('CpanelBundle:AutoEmails:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateIndexChoicesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $indexchoices = $em->getRepository('syndexAdminBundle:IndexChoices')->find($id);

        if (!$indexchoices) {
            throw $this->createNotFoundException('Unable to find New Article entity.');
        }

        $form = $this->createForm('index_choices', $indexchoices);


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();


                $indexchoices->setUpdateBy($this->getUser());
                $indexchoices->setUpdateTime(new \DateTime('now'));

                $em->flush();
                return $this->redirect($this->generateUrl('syndex_cpanel_indexchoices_list'));
            }
        }
        return $this->render('CpanelBundle:AutoEmails:update.html.twig', array(
            'form' => $form->createView(),
            'entity' => $indexchoices
        ));
    }


    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeIndexChoicesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $indexchoices = $em->getRepository('syndexAdminBundle:IndexChoices')->find($id);
        if (!$indexchoices) {
            throw $this->createNotFoundException(
                'No enquiry found for id ' . $id
            );
        }

        $indexchoices->setDeleted(1);
        $em->flush();

        $request->getSession()->getFlashBag()->add(
            'notice',
            'Delete is done.'
        );

        return $this->redirect($this->generateUrl('syndex_cpanel_indexchoices_list'));
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @return Response
     */
    public function showIndexChoicesAction(Request $request)
    {
        $id = $request->request->get('idF');
        $indexchoice = $this->getDoctrine()->getRepository('syndexAdminBundle:IndexChoices')->getIndexChoicesAdmin($id);
        $response = new Response(json_encode($indexchoice));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_INDEX_CHOICES')")
     * @param Request $request
     * @return Response
     */
    public function getTitleAction(Request $request)
    {
        $id = $request->request->get('id');
        $ref = $request->request->get('ref');

        $title = $this->getDoctrine()->getRepository('syndexNewsBundle:NewsArticle')->getTitleNews($ref);
        array_push($title, array('gid' => $id));
        $response = new Response(json_encode($title));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
