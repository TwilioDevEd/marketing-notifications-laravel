<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subscriber;

use Services_Twilio;

class NotificationsController extends Controller
{
    protected $client;

    public function __construct(Services_Twilio $client)
    {
        $this->client = $client;
    }

    /**
     * Show the form for creating a notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    public function send(Request $request)
    {
        $this->validate($request, ['message' => 'required']);

        $message  = $request->input('message');
        $imageUrl = $request->input('imageUrl');

        $activeSubscribers = Subscriber::active()->get();
        foreach ($activeSubscribers as $subscriber) {
            $this->sendMessage($subscriber->phoneNumber, $message, $imageUrl);
        }

        $request
            ->session()
            ->flash('status', 'Messages on their way!');

        return redirect()->route('notifications.create');
    }

    private function sendMessage($phoneNumber, $message, $imageUrl)
    {
        $twilioPhoneNumber = config('services.twilio')['phoneNumber'];
        $this->client->account->messages->sendMessage(
            $twilioPhoneNumber,
            $phoneNumber,
            $message,
            $imageUrl ? array($imageUrl) : null
        );
    }
}
