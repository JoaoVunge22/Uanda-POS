<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{

    // public $post;

    // public function __construct(Callback $post){
    //     $this->post = $post;
    // }

    //Callback
    public function callback(Request $request)
    {

	try {
     		$data = $request->all();
        	Log::info([
                'REQUEST ENVIADO POR PARCEIRO' => [
                    'Payload' => $data
                ],
            ]);
        	return response()->json($data,204);
	}catch(\Exception $e) {
            	Log::debug($e->getMessage());
        }
    }
}
