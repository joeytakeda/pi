<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Tests\Controller;

use App\DataFixtures\PlaylistFixtures;
use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;

class PlaylistControllerTest extends ControllerBaseCase {
    protected function fixtures() : array {
        return [
            UserFixtures::class,
            PlaylistFixtures::class,
        ];
    }

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/playlist/');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserIndex() : void {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/playlist/');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminIndex() : void {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/playlist/');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/playlist/1');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserShow() : void {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/playlist/1');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminShow() : void {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/playlist/1');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
