<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConsumoApi
{
    public function accessToken(){

        try{
            if(Cache::has('token')){
                return Cache::get('token');
            }else{
                //--Acess token
                $response_token = Http::withoutVerifying()->withBasicAuth('HeadMerchant', 'xmFGSQiUip')
                ->asForm()->post(env('API_UAT_AUTH').'v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);


                $token = $response_token->json();
                $key = 'token';
                $value = $token['access_token'];
                $seconds = $token['expires_in'];

                Cache::put($key, $value , $seconds);
                Log::debug('RESPONSE API AFRIMONEY ::{message}',['message' => $token]);

                return $value;
            }

        } catch(\Exception $exception) {
            Log::error('RESPONSE API AFRIMONEY Error::{error}',['error' => $exception->getMessage()]);
            return abort(401, 'Unauthorized');
        }

    }


    public function merchant_pay ($mpin, $sender, $amount, $received, $correletionId ){

        try{

            @$token = Self::accessToken();

            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.@$token,
                'X-User-Credential-1' => $mpin,
                'X-Callback-URL' => '',
                'X-CorrelationID' => $correletionId
            ])->post(env('API_UAT_AUTH').'v1.1/mm/transactions/type/merchantpay',[
                "amount" => $amount,
                "currency"=> "AOA",
                "debitParty" => [
                    [
                        "key"=> "msisdn",
                        "value"=> $sender
                    ]
                ],
                "creditParty"=> [
                    [
                        "key" => "msisdn",
                        "value" => $received
                    ]
                ]
            ]);

            Log::debug('RESPONSE API MERCHANT PAYI AFRIMONEY ::{message}',['message' => $response->json()]);
            return $response->json();

        } catch(\Exception $exception) {
            Log::error('RESPONSE API MERCHANT PAY AFRIMONEY Error::{error}',['error' => $exception->getMessage()]);
            return [
               'message' => 'error',
               'data' => 'Serviço Indisponivel, volte a tentar mais tarde.',
            ];
        }

    }

    public function enquiry_pay ($transactionID){

        try{

            $token = Self::accessToken();

            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ])->get(env('API_UAT_AUTH').'v1.1/mm/transactions/'.$transactionID);

            Log::debug('RESPONSE API TRANSACTION ENQUIRY ID PAYI AFRIMONEY ::{message}',['message' => $response->json()]);
            return $response->json();

        } catch(\Exception $exception) {
            Log::error('RESPONSE API TRANSACTION ENQUIRY ID PAY AFRIMONEY Error::{error}',['error' => $exception->getMessage()]);
            return [
                'message' => 'error',
                'data' => 'Serviço Indisponivel, volte a tentar mais tarde.',
            ];
        }
    }


}
