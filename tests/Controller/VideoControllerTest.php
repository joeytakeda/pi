<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Video;
use AppBundle\DataFixtures\ORM\LoadVideo;
use Nines\UserBundle\DataFixtures\ORM\LoadUser;
use Nines\UtilBundle\Tests\Util\BaseTestCase;

class VideoControllerTest extends BaseTestCase
{

    protected function getFixtures() {
        return [
            LoadUser::class,
            LoadVideo::class
        ];
    }
    
    public function testAnonIndex() {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/video/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testUserIndex() {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/video/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAdminIndex() {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/video/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testAnonShow() {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/video/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Profile')->count());
    }
    
    public function testUserShow() {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/video/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectButton('Profile')->count());
    }
    
    public function testAdminShow() {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/video/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(1, $crawler->selectLink('Profile')->count());
        $this->assertGreaterThan(1, $crawler->selectLink('Profile')->count());
    }

}
