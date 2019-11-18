<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProfileKeyword;
use AppBundle\Entity\Video;
use AppBundle\Entity\VideoProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProfileKeyword controller.
 *
 * @Route("/profile_keyword")
 */
class ProfileKeywordController extends Controller {

    /**
     * Lists all ProfileKeyword entities.
     *
     * @Route("/", name="profile_keyword_index", methods={"GET"})
     *
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $dql = 'SELECT e FROM AppBundle:ProfileKeyword e ORDER BY e.id';
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $profileKeywords = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'profileKeywords' => $profileKeywords,
        );
    }

    /**
     * Finds and displays a ProfileKeyword entity.
     *
     * @Route("/{id}", name="profile_keyword_show", methods={"GET"})
     *
     * @Template()
     *
     * @param ProfileKeyword $profileKeyword
     *
     * @return array
     */
    public function showAction(ProfileKeyword $profileKeyword) {
        $repo = $this->getDoctrine()->getRepository(Video::class);
        $query = $repo->findVideosQuery($this->getUser(), array(
            'type' => VideoProfile::class,
            'id' => $profileKeyword->getId(),
        ));

        return array(
            'profileKeyword' => $profileKeyword,
            'videos' => $query->execute(),
        );
    }
}
