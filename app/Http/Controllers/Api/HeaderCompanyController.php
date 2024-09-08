<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeaderCompane;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HeaderCompanyController extends Controller
{
    public HeaderCompane $post;

    public function __construct(HeaderCompane $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        if(request('user_id')){
            $data = HeaderCompane::where('user_id',request('user_id') )->fisrt();
        }else{
            $data = HeaderCompane::paginate(10);
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(empty($request->name)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Preencha todos os campos'
            ], 401);
        }

        if(HeaderCompane::where('name',$request->name)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Ja existe uma wallet com este nome :'.$request->name.''
            ], 401);
        }

        $data = $request->all();
        HeaderCompane::create($data);

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

        $data = HeaderCompane::with('Compone')->where('id',$id)->get();
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

        if(!$walleet=HeaderCompane::where('id',$id)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Não existe uma wallet com este ID :'.$id.''
            ], 401);
        }

        $data = HeaderCompane::find($id);
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

        $data = HeaderCompane::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }
}
