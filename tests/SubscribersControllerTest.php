<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Subscriber;

class SubscribersControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateSubscriber()
    {
        $this->assertCount(0, Subscriber::all());

        $response = $this->call(
            'GET',
            route('subscribers.register'),
            ['From' => '555-5555', 'Body' => '']
        );

        $twilioResponse = new SimpleXMLElement($response->getContent());
        $this->assertContains('Thanks', strval($twilioResponse->Message));
        $this->assertCount(1, Subscriber::all());
    }

    public function testSubscribeSubscriber()
    {
        $subscriber = $this->createSubscriber();
        $this->assertCount(1, Subscriber::all());

        $response = $this->call(
            'GET',
            route('subscribers.register'),
            ['From' => '555-5555', 'Body' => 'subscribe']
        );

        $twilioResponse = new SimpleXMLElement($response->getContent());
        $this->assertContains('subscribed', strval($twilioResponse->Message));
        $this->assertCount(1, Subscriber::all());
    }

    public function testUnsubscribeSubscriber()
    {
        $subscriber = $this->createSubscriber();
        $this->assertCount(1, Subscriber::all());

        $response = $this->call(
            'GET',
            route('subscribers.register'),
            ['From' => '555-5555', 'Body' => 'unsubscribe']
        );

        $twilioResponse = new SimpleXMLElement($response->getContent());
        $this->assertContains('unsubscribed', strval($twilioResponse->Message));
        $this->assertCount(1, Subscriber::all());
    }

    public function testUnrecognizedCommand()
    {
        $subscriber = $this->createSubscriber();
        $this->assertCount(1, Subscriber::all());

        $response = $this->call(
            'GET',
            route('subscribers.register'),
            ['From' => '555-5555', 'Body' => 'command']
        );

        $twilioResponse = new SimpleXMLElement($response->getContent());
        $this->assertContains('Sorry', strval($twilioResponse->Message));
        $this->assertCount(1, Subscriber::all());
    }

    private function createSubscriber()
    {
        $subscriber = new Subscriber;
        $subscriber->phoneNumber = '555-5555';
        $subscriber->subscribed  = false;
        $subscriber->save();

        return $subscriber;
    }
}
