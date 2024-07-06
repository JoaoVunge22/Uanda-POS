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

        $walletID = request('wallet_id');
        $userID = request('user_id');

        if(!empty($userID) or !empty( $walletID) ){
            $data = Transaction::where('userID', $userID )->orWhere('walletID', $walletID )->latest()->get();
        }else{
            $data = Transaction::latest()->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }


    public function store(Request $request)
    {

        Log::info('REQUEST SET MOBILE APP TO GETAWAY ::',$request->all());

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
                    'userID' => $request->userID,
                    'walletID' => '',
                    'status' => $data['data']['status'],
                    'errorMessage' => '',
                    'errorCode' => '',
                    'compane_id' => $request->compane_id,
                ]);
            }else{
                if(!empty(@$data['errordescription'])){
                    return [
                        'message' => 'error',
                        'data' => $data['errordescription']
                    ];
                }
            }

            Log::info('RESPONSE SET TO MOBILE APP ::',@$data);
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
                'status' => 'Pago'
            ]);
        }elseif(@$response['transactionStatus'] == 'failed'){
            $data->update([
                'errorMessage' => '',
                'errorCode' => '',
                'status' => 'Cancelado'
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
