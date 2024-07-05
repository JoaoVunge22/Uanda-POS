<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public Wallet $post;

    public function __construct(Wallet $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $data = Wallet::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(empty($request->name) and empty($request->status)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Preencha todos os campos'
            ], 401);
        }

        if(Wallet::where('name',$request->name)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Ja existe uma wallet com este nome :'.$request->name.''
            ], 401);
        }

        $data = $request->all();
        Wallet::create($data);

        return response()->json([
            'data' => $data,
            'message' => 'Criado com sucesso.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(empty($id)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Indentificador inavalida'
            ], 401);
        }

        $data = Wallet::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        if(empty($id)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Indentificador inavalida'
            ], 401);
        }

        if(!$walleet=Wallet::where('id',$id)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Não existe uma wallet com este ID :'.$id.''
            ], 401);
        }

        $data = Wallet::find($id);
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

        $data = Wallet::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }
}
