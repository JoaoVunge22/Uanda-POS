<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compane;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public Compane $post;

    public function __construct(Compane $post)
    {
        $this->post = $post;
    }

    public function index()
    {

        if(request('header_compane_id') ){
            $data = Compane::with(['user','header_compane'])
            ->where('header_compane_id','like','%'.request('header_compane_id').'%')
            ->get();
        }else{
            $data = Compane::paginate(10);
        }

        return response()->json([
            'data' => $data
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

        if(Compane::where('name',$request->name)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Ja existe uma wallet com este nome :'.$request->name.''
            ], 401);
        }

        $data = $request->all();
        Compane::create($data);

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

        $data = Compane::where('id',$id)->get();
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

        if(!$walleet=Compane::where('id',$id)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Não existe uma wallet com este ID :'.$id.''
            ], 401);
        }

        $data = Compane::find($id);
        $data->update(
            $request->all()
        );

        return response()->json([
            'data' => $data,
            'message' => 'Atualizado com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $data = Compane::find($id);
        $data->delete();

        return response()->json([
            'data' => $data,
            'message' => 'Removido com sucesso.'
        ]);
    }
}
