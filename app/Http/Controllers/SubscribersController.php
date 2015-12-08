<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Services_Twilio_Twiml;

class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $response = new Services_Twilio_Twiml;
        $response->message('twilio');

        return response($response)
            ->header('Content-Type', 'text/xml');
    }

}
