<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public User $post;

    public function __construct(User $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $data = User::where('grade','=','Admin')->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(empty($request->first_name) or empty($request->last_name) or empty($request->username) or empty($request->password) or empty($request->confirmpassword) or empty($request->rule)){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Preencha todos os campos.'
                ]);
        }


        if($request->grade != 'Admin'){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Grade invalido, Preencha todos os campos.'
                ]);
        }

        if(User::where('email','=',$request->email)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Nome de usuario ja existe.'
                ]);
        }

        if($request->confirmpassword == $request->password){
            $pass = Hash::make($request->password);
            $request->password = $pass;

            if($create = $this->post->create($request->all())){
                return response()->json([
                    'data' => $create,
                    'message' => 'Usuario criado com sucesso!'
                ]);
            }else{
                return response()->json([
                    'message' => "Usuario não criado",
                ], 422);
            }
        }else{
            return response()->json([
                'message'=> "Senha de confirmação errada.",
            ], 401);
        }
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

        $data = User::find($id);
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

        $data = User::find($id);
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

        if(empty($id)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Indentificador inavalida'
            ], 401);
        }

        $data = User::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }
}
