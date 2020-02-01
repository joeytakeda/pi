<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\DataFixtures\ORM\LoadPlaylist;
use Nines\UserBundle\DataFixtures\ORM\LoadUser;
use Nines\UtilBundle\Tests\Util\BaseTestCase;

class PlaylistControllerTest extends BaseTestCase
{

    protected function getFixtures() {
        return [
            LoadUser::class,
            LoadPlaylist::class
        ];
    }
    
    public function testAnonIndex() {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/playlist/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testUserIndex() {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/playlist/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAdminIndex() {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/playlist/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAnonShow() {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/playlist/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
    
    public function testUserShow() {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/playlist/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAdminShow() {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/playlist/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
}
