<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Channel;
use AppBundle\Form\ChannelType;
use AppBundle\Services\YoutubeClient;

/**
 * Channel controller.
 *
 * @Route("/channel")
 * @Security("has_role('ROLE_USER')")
 */
class ChannelController extends Controller {

    /**
     * Lists all Channel entities.
     *
     * @Route("/", name="channel_index")
     * @Method("GET")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $dql = 'SELECT e FROM AppBundle:Channel e ORDER BY e.id';
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $channels = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'channels' => $channels,
        );
    }

    /**
     * Finds and displays a Channel entity.
     *
     * @Route("/{id}", name="channel_show")
     * @Method("GET")
     * @Template()
     * @param Channel $channel
     */
    public function showAction(Channel $channel) {

        return array(
            'channel' => $channel,
        );
    }

    /**
     * Finds and displays a Playlist entity.
     *
     * @Route("/{id}/refresh", name="channel_refresh")
     * @Method("GET")
     * @Security("has_role('ROLE_CONTENT_ADMIN')")
     * @param Channel $channel
     */
    public function refreshAction(Channel $channel, YoutubeClient $client) {
        $em = $this->getDoctrine()->getManager();
        $client->updateChannels(array($channel));
        $em->flush();
        $this->addFlash('success', 'The playlist metadata has been updated.');
        return $this->redirectToRoute('channel_show', array(
                    'id' => $channel->getId()
        ));
    }

}
