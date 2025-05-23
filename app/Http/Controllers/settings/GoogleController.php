<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;
use Google_Client;
use Google\Service\Calendar;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(Calendar::CALENDAR);
        $client->setRedirectUri(route('google.callback'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request){
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(Calendar::CALENDAR);
        $client->setRedirectUri(route('google.callback'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);
        file_put_contents(storage_path('app/google-calendar/token.json'), json_encode($token));

        return redirect()->route('calendar.index')->with('success', 'Google Calendar conectado exitosamente');
    }
}
