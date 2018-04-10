<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace syndex\CpanelBundle\Services;

use syndex\PlacesBundle\Entity\Places;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Description of NewPlaceHandler
 *
 * @author Slaiman
 */
class CpanelPlacesService
{

    protected $em;
    private $twig;
    private $templating;
    private $srevicecomment;

    /**
     * CpanelPlacesService constructor.
     * @param EngineInterface $templating
     * @param ObjectManager $em
     */
    public function __construct(EngineInterface $templating, ObjectManager $em, $srevicecomment)
    {
        $this->em = $em;
        $this->templating = $templating;
        $this->srevicecomment = $srevicecomment;
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_PLACES')")
     * @param Places $place
     * @param string $msg
     * @return string
     */
    public function profile(Request $request, Places $place, $msg = "")
    {

        //GET ID OF CURRENT PLACE
        $id = $place->getId();
        $invid = $place->getInvId();
        //GET COMMENTS OF CURRENT PLACE
        //  $comments = $this->em->getRepository('UserBundle:Comment')->findByPlace($id);
        $comments = $this->getComments($invid);

        //GET NEAREST PLACES FOR CURRENT PLACE
        $places = $this->em->getRepository('syndexPlacesBundle:Places')->getAdminPlacesByDistance($place->getLat(), $place->getLng(), "", 0, "distance ASC");

        //GET NEAREST PLACES FOR CURRENT PLACE
        $refusedPlaces = sizeof($this->em->getRepository('syndexPlacesBundle:Places')->getRefusedPlaces4User($place->getAddBy()));

        //CHECK IF THESRE IS OWNENG REQUEST FOR CURRENT PLACE
        $ownerreq = $this->em->getRepository('syndexContactUsBundle:PlacesOwnerRequest')->checkExistanceOwnerRequest($place);

        return $this->templating->render('CpanelBundle:Places:profile.html.twig', array(
            'place' => $place,
            'comments' => $comments,
            'places' => $places,
            'ownerreq' => $ownerreq,
            'msg' => $msg,
            'refusedPlaces' => $refusedPlaces,
        ));
//        return false;
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_PLACES')")
     * @param $invId
     */
    public function hidePlace($invId)
    {
        $place = $this->em->getRepository('syndexPlacesBundle:Places')->findBy(array('invId' => $invId));
        $place[0]->setVerified(-5);
    }

    /**
     * @security("has_role('ROLE_SUPER_ADMIN') or has_role('ROLE_SONATA_ADMIN_PLACES')")
     * @param $id
     * @return string
     */
    public function getComments($id, $start = 0, $end = 100000)
    {
        $thread = $this->em->getRepository('UserBundle:Thread')->findOneBy(
            ['type' => "place",
                'typeID' => $id,
            ]
        );
        $comments = "";
        if ($thread) {
            $qb = $this->em->createQueryBuilder()
                ->select("c.id, c.text text, c.datetime, '".$thread->getId()."', IDENTITY(c.parent) as parent,
                   u.username, u.firstName as first_name, u.lastName as last_name, u.image as user_pic, u.gender,
                   s.profilePhoto,
                   count(v.vote) as totals,
                   (SELECT count(r.id) FROM UserBundle:Comment as r WHERE r.parent = c AND r.deleted = 0) as replays_count,
                   sum(v.vote) as votes,
                   sum(CASE v.vote WHEN 1 THEN 1 ELSE 0 END) as yes,
                   sum(CASE v.vote WHEN -1 THEN 1 ELSE 0 END) as no");

            $qb->from('UserBundle:Comment', 'c')
                ->join('UserBundle:User', 'u', Join::WITH, 'c.user = u')
                ->leftJoin('syndexNassBundle:NassSettings', 's', Join::WITH, 'c.user = s.userId')
                ->leftJoin(
                    'UserBundle:Vote',
                    'v',
                    Join::WITH,
                    'v.comment = c and v.deleted = 0'
                );

            $qb->where('c.thread = :thread')
                ->andWhere('c.parent IS NULL')
                ->andWhere('c.deleted = 0')
                ->setParameter('thread', $thread->getId())
                ->groupBy('c.id')
                ->addGroupBy('u.username');


            $comments = $qb->setFirstResult($start)
                ->setMaxResults($end)->getQuery()->getResult();


        }
        
        return $comments;
    }

}
