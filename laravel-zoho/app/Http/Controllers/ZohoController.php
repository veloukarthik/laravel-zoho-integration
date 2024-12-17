<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    // Redirect to Zoho's OAuth URL
    public function redirectToZoho()
    {
        $authUrl = env('ZOHO_AUTH_URL', 'https://accounts.zoho.com/oauth/v2/auth');
        $clientId = env('ZOHO_CLIENT_ID', '1000.M404RRYT05LKIB6N0G02VYMIBY9BAI');
        $redirectUri = env('ZOHO_REDIRECT_URI', 'http://localhost:8000/api/zoho-auth/callback');
        $scope = 'ZohoCRM.modules.contacts.READ,ZohoCRM.modules.accounts.READ';

        return redirect("$authUrl?client_id=$clientId&response_type=code&redirect_uri=$redirectUri&scope=$scope&access_type=offline");
    }

    // Handle the callback and exchange code for tokens
    public function handleZohoCallback(Request $request)
    {
        try {
            $code = $request->get('code');

            if (!$code) {
                return response()->json(['error' => 'Authorization code not received'], 400);
            }

            $data = [
                'client_id' => env('ZOHO_CLIENT_ID', '1000.M404RRYT05LKIB6N0G02VYMIBY9BAI'),
                'client_secret' => env('ZOHO_CLIENT_SECRET', '6f586230a8e74525fcb11b45563ea964830ac02f40'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => env('ZOHO_REDIRECT_URI', 'http://localhost:8000/api/zoho-auth/callback'),
            ];


            $response = Http::asForm()->post(
                'https://accounts.zoho.com/oauth/v2/token',
                $data
            );

            $result = $response->json();

            if (isset($result['access_token'])) {
                session(['zoho_access_token' => $result['access_token']]);
                session(['zoho_refresh_token' => $result['refresh_token']]);

                \Log::info('Tokens Stored', [
                    'access_token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token']
                ]);
                // return response()->json($data);
                $contacts = $this->getContacts($result['access_token']);
                $accounts = $this->getAccounts($result['access_token']);

                return response()->json(['contacts' => $contacts, 'accounts' => $accounts]);
            }

            return response()->json(['error' => $result['error'] ?? 'Unknown error'], 400);
        } catch (\Exception $e) {
            \Log::error('Zoho Callback Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Fetch contacts from Zoho
    public function getContacts($accessToken)
    {

        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken $accessToken"
        ])->get(env('ZOHO_API_URL', 'https://www.zohoapis.com/crm/v2') . '/Contacts');

        return response()->json($response->json());
    }

    // Fetch accounts from Zoho
    public function getAccounts($accessToken)
    {


        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken $accessToken"
        ])->get(env('ZOHO_API_URL', 'https://www.zohoapis.com/crm/v2') . '/Accounts');

        return response()->json($response->json());
    }
}
