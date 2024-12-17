<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
class ZohoAuthController extends Controller
{
    public function zohoCallback(Request $request)
    {
        return $request;
        // return response()->json([
        //     'message' => 'Callback received successfully',
        //     'data' => $request->all(),
        // ]);
    }   

    public function ZohoAuth()
    {
        $client_id = env('ZOHO_CLIENT_ID','1000.M404RRYT05LKIB6N0G02VYMIBY9BAI');
        $client_secret = env('ZOHO_CLIENT_SECRET','6f586230a8e74525fcb11b45563ea964830ac02f40');
        $redirect_uri = 'http://localhost:8000/api/zoho-auth/callback';

        return redirect('https://accounts.zoho.com/oauth/v2/auth?client_id='. $client_id. '&response_type=code&scope=ZohoCRM.modules.ALL&redirect_uri='. $redirect_uri);
    }
    //
    public function authenticate(Request $request)
    {
        $client_id = env('ZOHO_CLIENT_ID','1000.M404RRYT05LKIB6N0G02VYMIBY9BAI');
        $client_secret = env('ZOHO_CLIENT_SECRET','e873b555d7fb15007f2fdbbee07a7150462c5b0389');
        $redirect_uri = 'http://localhost:8000/api/zoho-auth/callback';

        $response = Http::post('https://accounts.zoho.com/oauth/v2/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => '1000.438b15776988ca9197e5723d8e3d054a.e49e05dccff0e055f8d6fd114a3e4858',
            'grant_type' => 'authorization_code',
           'redirect_uri' => $redirect_uri,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return response()->json($data);
        } else {
            Log::error($response->body());
            return  $response->body();
        }
    }

    public function GetAccounts()
    {
        $accessToken = '<your_access_token>';

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
        ])->get('https://www.zohoapis.com/crm/v2/Accounts');

        if ($response->successful()) {
            $contacts = $response->json();
            return response()->json($contacts);
        } else {
            Log::error($response->body());
            return response()->json(['error' => $response->body()], 400);
        }
    }

    public function getContacts()
    {
        $accessToken = '<your_access_token>';

        $response = Http::withHeaders([
            'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
        ])->get('https://www.zohoapis.com/crm/v2/Contacts');

        if ($response->successful()) {
            $contacts = $response->json();
            return response()->json($contacts);
        } else {
            Log::error($response->body());
            return response()->json(['error' => $response->body()], 400);
        }
    }
}
