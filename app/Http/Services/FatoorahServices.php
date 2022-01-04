<?php
namespace App\Http\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class FatoorahServices
{

    private $request_client;
    private $base_url;
    private $headers;

    /**
     * FatoorahServices constructor.
     * @param Client $request_client
     */
    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = env('fatoora_base_url');

        $this->headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Bearer ' . env('fatoorah_token')
        ];
    }

    private function establish_connection($url, $method , $data = []){


        $request = new Request( $method, $this->base_url . $url , $this->headers); // to make a connection

        if (!$data){
            return false;
        }

        $response = $this->request_client->send($request , [
            'json' => $data
        ]);

        if ($response->getStatusCode() != 200){
            return false;
        }

        $response = json_decode($response->getBody(), true);

        return $response;


    }


    public function sendPayment($data){
        return $response = $this->establish_connection('/v2/SendPayment', 'POST', $data);  //v2/SendPayment   the end point to sendPayment call it
    }

    public function getPaymentStatus($data)
    {
        return $response = $this->establish_connection('/v2/getPaymentStatus', 'POST', $data);  //v2/getPaymentStatus  //Call endpoint to getPaymentStatus

    }


}
