<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subscriber;

use Services_Twilio_Twiml;

class SubscribersController extends Controller
{
    /**
     * Manage subscription for a subscriber.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $phoneNumber   = $request->input('From');
        $message       = $request->input('Body');
        $outputMessage = $this->createMessage($phoneNumber, $message);

        $response = new Services_Twilio_Twiml;
        $response->message($outputMessage);

        return response($response)
            ->header('Content-Type', 'text/xml');
    }

    private function createMessage($phone, $message)
    {
        $subscriber = Subscriber::where('phone_number', $phone)->first();
        if ($subscriber)
        {
            return $this->generateOutputMessage($subscriber, $message);
        }

        $subscriber = new Subscriber;
        $subscriber->phoneNumber = $phone;
        $subscriber->subscribed  = false;

        $subscriber->save();

        return 'Thanks for contacting TWBC! Text \'subscribe\' if you would to receive updates via text message.';
    }

    private function generateOutputMessage($subscriber, $message) {
        $subscribe   = 'subscribe';

        if (!$this->isValidCommand($message))
        {
            return 'Sorry, we don\'t recognize that command. Available commands are: \'subscribe\' or \'unsubscribe\'.';
        }

        $isSubscribed = starts_with($message, $subscribe);
        $subscriber->subscribed = $isSubscribed;
        $subscriber->save();

        return $isSubscribed
            ? 'You are now subscribed for updates.'
            : 'You have unsubscribed from notifications. Test \'subscribe\' to start receieving updates again';
    }

    private function isValidCommand($command)
    {
        return starts_with($command, 'subscribe') || starts_with($command, 'unsubscribe');
    }
}
