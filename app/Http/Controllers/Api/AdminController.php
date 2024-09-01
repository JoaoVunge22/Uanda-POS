<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public Admin $post;

    public function __construct(Admin $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $data = Admin::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(empty($request->name) or empty($request->email) or empty($request->password) or empty($request->rule_id) or empty($request->header_compane_id)){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Preencha todos os campos.'
                ]);
        }

        if(Admin::where('email','=',$request->email)->exists()){
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

        $data = Admin::find($id);
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

        $data = Admin::find($id);
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

        $data = Admin::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }
}
