<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HandlesOAuthRequests
{
    /**
     * Send OAuth request to get a token.
     *
     * @param string $grant_type
     * @param array $credentials
     * @return \Illuminate\Http\Client\Response
     */
    public function sendOAuthRequest(string $grant_type, array $credentials)
    {
        $data = array_merge([
            'grant_type' => $grant_type,
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'scope' => '*',
        ], $credentials);

        $response = Http::asForm()->post('http://currency.exchanger.local.com/oauth/token', $data);

        if (!$response->successful()) {
            Log::channel('auth')->error("OAuth request error: {$response->json()}");
        }

        return $response;
    }
}
