<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribersControllerTest extends TestCase
{
    public function testRegistration()
    {
        $response       = $this->call('GET', route('subscribers.register'));
        $twilioResponse = new SimpleXMLElement($response->getContent());

        $this->assertContains('twilio', $twilioResponse->Message);
    }
}
