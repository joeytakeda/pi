<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Caption;
use AppBundle\Form\CaptionType;
use AppBundle\Services\YoutubeClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Caption controller.
 *
 * @Route("/caption")
 */
class CaptionController extends Controller {

    /**
     * Lists all Caption entities.
     *
     * @Route("/", name="caption_index")
     *
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Caption::class);
        $query = $repo->findCaptionsQuery($this->getUser());
        $paginator = $this->get('knp_paginator');
        $captions = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'captions' => $captions,
        );
    }

    /**
     * Finds and displays a Caption entity.
     *
     * @Route("/{id}", name="caption_show")
     *
     * @Template()
     * @param Caption $caption
     */
    public function showAction(Caption $caption) {

        if($this->getuser() === null && $caption->getVideo()->getHidden()) {
            throw new NotFoundHttpException();
        }

        return array(
            'caption' => $caption,
        );
    }

}
