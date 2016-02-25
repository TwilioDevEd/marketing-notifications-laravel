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
     * Manage the subscription for a subscriber.
     *
     * @param Request $request
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
        if ($subscriber) {
            return $this->generateOutputMessage($subscriber, $message);
        }

        $subscriber = new Subscriber;
        $subscriber->phoneNumber = $phone;
        $subscriber->subscribed  = false;

        $subscriber->save();

        return trans('subscription.thanks');
    }

    private function generateOutputMessage($subscriber, $message)
    {
        $subscribe   = 'add';

        if (!$this->isValidCommand($message)) {
            return trans('subscription.unavailable_command');
        }

        $isSubscribed = starts_with($message, $subscribe);
        $subscriber->subscribed = $isSubscribed;
        $subscriber->save();

        return $isSubscribed
            ? trans('subscription.subscribed_confirmation')
            : trans('subscription.unsubscribed_confirmation');
    }

    private function isValidCommand($command)
    {
        return starts_with($command, 'add') || starts_with($command, 'remove');
    }
}
