<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public User $post;

    public function __construct(User $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        if(request('user_id')){
            $data = User::where('id', 'like','%'.request('user_id').'%')
            ->where('id', 'like','%'.request('compane_id').'%')
            ->where('id', 'like','%'.request('header_compane_id').'%')
            ->where('grade', '=','User')
            ->get();
        }else{
            $data = User::where('grade','=','User')->get();
        }


        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data = $request->all();
    //     User::created($data);

    //     return response()->json([
    //         'data' => $data,
    //         'message' => 'Criado com sucesso.'
    //     ]);
    // }

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
