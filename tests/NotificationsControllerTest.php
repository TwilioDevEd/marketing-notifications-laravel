<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Subscriber;

class NotificationsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->call('GET', route('notifications.create'));

        $this->assertResponseOk();
    }

    public function testDeliverNotifications()
    {
       $this->startSession();
       $subscriber = $this->createSubscriber();

       $mockClient   = Mockery::mock('Services_Twilio')->makePartial();
       $mockAccount  = Mockery::mock();
       $mockMessages = Mockery::mock();
       $mockClient->account   = $mockAccount;
       $mockAccount->messages = $mockMessages;

       $twilioPhoneNumber = config('services.twilio')['phoneNumber'];
       $mockMessages
           ->shouldReceive('sendMessage')
           ->with($twilioPhoneNumber, $subscriber->subscribed, 'message', null)
           ->once();

       $this->app->instance(
           'Services_Twilio',
           $mockClient
       );

       $response = $this->call(
           'POST',
           route('notifications.send'),
           ['message' => 'message', '_token' => csrf_token()]
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
