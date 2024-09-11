<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ConsumoApi;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    public Transaction $post;

    public function __construct(Transaction $post)
    {
        $this->post = $post;
    }

    public function index()
    {

        if(!empty(request('user_id')) or !empty( request('compane_id')) or !empty( request('header_compane_id')) ){
            $data = Transaction::with(['user_id','compane_id'])->where('user_id', 'like','%'.request('user_id').'%')
            ->where('compane_id', 'like','%'.request('compane_id').'%')
            ->where('header_compane_id', 'like','%'.request('header_compane_id').'%')
            ->latest()
            ->get();
        }else{
            $data = Transaction::with(['user_id','compane_id'])->latest()->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }


    public function store(Request $request)
    {

        Log::info('REQUEST SET MOBILE APP TO GETAWAY :: {message}',['message'=> $request->all()]);

        $PIN = $request->header('PIN');
        $correletionId = 'MB.12312.'.rand(1,10);

        $Myapis = new ConsumoApi();
        $data = $Myapis->merchant_pay($PIN, $request->sender, $request->amount, $request->receiver, $correletionId );


        if(@$data['message'] == 'error'){
            return  response()->json($data);
        }else{
            if(@$data['status'] == 'pending'){
                $data = [
                    'message' => 'completed',
                    'data' => $data
                ];

                Transaction::create([
                    'sender' => $request->sender,
                    'receiver' => $request->receiver,
                    'referenceID' => $correletionId,
                    'transferID' => $data['data']['objectReference'],
                    'amount' => $request->amount,
                    'user_id' => $request->user_id,
                    'wallet' => $request->wallet,
                    'status' => $data['data']['status'],
                    'errorMessage' => '',
                    'errorCode' => '',
                    'compane_id' => $request->compane_id,
                    'header_compane_id' => $request->header_compane_id,
                ]);
            }else{
                if(!empty(@$data['errordescription'])){
                    return [
                        'message' => 'error',
                        'data' => $data['errordescription']
                    ];
                }
            }

            Log::info('RESPONSE SET TO MOBILE APP ::{message}',['message'=> @$data]);
            return response()->json($data );
        }


    }


    public function show($id)
    {

        $Myapis = new ConsumoApi();
        $response = $Myapis->enquiry_pay($id);

        $data = Transaction::where('transferID',$id)->first();

        if(@$response['transactionStatus'] == 'success'){
            $data->update([
                'status' => 'Confirmado'
            ]);
        }elseif(@$response['transactionStatus'] == 'failed'){
            $data->update([
                'errorMessage' => '',
                'errorCode' => '',
                'status' => 'Falhado'
            ]);
        }

        return response()->json([
            'data' => $response['transactionStatus'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        if(!$walleet=Transaction::where('transferID',$id)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Não existe uma wallet com este ID :'.$id.''
            ], 401);
        }

        $data = Transaction::where('transferID',$id)->first();
        $data->update(
            $request->all()
        );

        return response()->json([
            'data' => $request->all(),
            'message' => 'Atualizado com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $data = Transaction::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }

}
