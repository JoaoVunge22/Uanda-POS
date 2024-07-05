<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public Rule $post;

    public function __construct(Rule $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $data = Rule::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(empty($request->grupo) and empty($request->rule)){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Preencha todos os campos'
            ], 401);
        }

        if(Rule::where('grupo',$request->grupo)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Ja existe uma wallet com este nome :'.$request->grupo.''
            ], 401);
        }

        $data = $request->all();
        Rule::create($data);

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

        $data = Rule::find($id);
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

        if(!$walleet=Rule::where('id',$id)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Não existe uma wallet com este ID :'.$id.''
            ], 401);
        }

        $data = Rule::find($id);
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

        $data = Rule::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }

}
