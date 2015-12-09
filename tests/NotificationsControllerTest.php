<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsControllerTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->call('GET', route('notifications.create'));

        $this->assertEquals(200, $response->status());
    }
}
