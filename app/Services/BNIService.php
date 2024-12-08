<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class BNIService
{
    protected $client_id;
    protected $secret_key;
    protected $api_url;

    public function __construct()
    {
        $this->client_id = env('BNI_CLIENT_ID');
        $this->secret_key = env('BNI_SECRET_KEY');
        $this->api_url = env('BNI_API_URL'); // Pastikan API URL sudah benar
    }

    public function createVirtualAccount($amount, $email, $description)
    {
        $data = [
            'client_id' => $this->client_id,
            'secret_key' => $this->secret_key,
            'amount' => $amount,
            'email' => $email,
            'description' => $description,
        ];

        // Pastikan endpointnya benar
        $response = Http::post($this->api_url . '/create_virtual_account', $data);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to create virtual account: ' . $response->body());
        }
    }
}
