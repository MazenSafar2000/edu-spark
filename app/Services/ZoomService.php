<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ZoomService
{
    private $accountId;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->accountId    = config('services.zoom.account_id');
        $this->clientId     = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
    }

    /**
     * Get Zoom Access Token (cached for 1 hour)
     */
    private function getAccessToken()
    {
        return Cache::remember('zoom_access_token', 3500, function () {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'account_credentials',
                    'account_id' => $this->accountId,
                ]);


            if ($response->failed()) {
                throw new \Exception('Failed to get Zoom access token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    /**
     * Create a Zoom Meeting
     */
    public function createMeeting(array $data): array
    {
        $token = $this->getAccessToken();

        $payload = [
            'topic'      => $data['topic'],
            'type'       => 2, // scheduled meeting
            'start_time' => $data['start_iso'], // UTC ISO8601
            'timezone'   => $data['timezone'] ?? 'UTC',
            'duration'   => $data['duration'] ?? 30,
            'password'   => $data['password'] ?? null,
            'settings'   => [
                'join_before_host' => true,
                'approval_type'    => 0,
                'registration_type' => 1,
                'audio'            => 'both',
                'auto_recording'   => 'none',
            ],
        ];

        $response = Http::withToken($token)->post("https://api.zoom.us/v2/users/me/meetings", $payload);

        if ($response->failed()) {
            throw new \Exception('Failed to create Zoom meeting: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Delete a Zoom Meeting
     */
    public function deleteMeeting($meetingId): bool
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)->delete("https://api.zoom.us/v2/meetings/{$meetingId}");
        // dd($response->status(), $response->body());

        return $response->successful();
    }
}
