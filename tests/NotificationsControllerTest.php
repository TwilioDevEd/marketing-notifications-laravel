<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Subscriber;
use Twilio\Rest\Client;

class NotificationsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeliverNotificationsWithoutImage()
    {
        $this->startSession();
        $subscriber = $this->createSubscriber();

        $mockClient   = Mockery::mock(Client::class)->makePartial();
        $mockMessages = Mockery::mock();
        $mockClient->messages = $mockMessages;

        $twilioPhoneNumber = config('services.twilio')['phoneNumber'];
        $mockMessages
            ->shouldReceive('create')
            ->with(
                $subscriber->phoneNumber,
                array(
                    'from' => $twilioPhoneNumber,
                    'body' => 'message'
                )
            )
            ->once();

         $this->app->instance(
             Client::class,
             $mockClient
         );

         $response = $this->call(
             'POST',
             route('notifications.send'),
             [
                'message' => 'message',
                '_token' => csrf_token()
             ]
         );
         $this->assertResponseStatus(302);
         $this->assertRedirectedToRoute('notifications.create');
    }

    public function testDeliverNotificationsWithImage()
    {
        $this->startSession();
        $subscriber = $this->createSubscriber();

        $mockClient   = Mockery::mock(Client::class)->makePartial();
        $mockMessages = Mockery::mock();
        $mockClient->messages = $mockMessages;

        $twilioPhoneNumber = config('services.twilio')['phoneNumber'];
        $mockMessages
            ->shouldReceive('create')
            ->with(
                $subscriber->phoneNumber,
                array(
                    'from' => $twilioPhoneNumber,
                    'body' => 'message',
                    'mediaUrl' => 'some URL'
                )
            )
            ->once();

         $this->app->instance(
             Client::class,
             $mockClient
         );

         $response = $this->call(
             'POST',
             route('notifications.send'),
             [
                'message' => 'message',
                'imageUrl' => 'some URL',
                '_token' => csrf_token()
             ]
         );
         $this->assertResponseStatus(302);
         $this->assertRedirectedToRoute('notifications.create');
    }

    private function createSubscriber()
    {
        $subscriber = new Subscriber;
        $subscriber->phoneNumber = '555-5555';
        $subscriber->subscribed  = true;
        $subscriber->save();

        return $subscriber;
    }
}
