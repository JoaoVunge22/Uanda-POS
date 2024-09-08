<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public User $post;

    public function __construct(User $post)
    {
        $this->post = $post;
    }

    public function login(Request $request)
    {

        if(empty($request->username) or empty($request->password)){
            return response()->json([
                'messageError' => 'Preencha todos os campos por favor.',
            ]);
        }

        $credentials = $request->only(
            'username',
            'password'
        );

        if (Auth::attempt($credentials)) {
            $data = Auth::user();
            $dataUser = $data->createToken('myapptoken');
            $User = Auth::user();

            return response()->json([
                'data'=>$data,
                'expires_in' => '0',
                'token_type' => 'bearer',
                'access_token' => $dataUser->plainTextToken,
            ]);
        }else{
            return response()->json([
                'error'=> 'errorAuthentication',
                'messageError' => 'Credencias inavalidas'
            ]);
        }

    }

    //adinlogin
    public function adinlogin(Request $request)
    {

        if(empty($request->email) or empty($request->password)){
            return response()->json([
                'messageError' => 'Preencha todos os campos por favor.',
            ]);
        }

        $credentials = $request->only(
            'email',
            'password'
        );

        if (Auth::attempt($credentials)) {
            $data = Auth::user();
            $dataUser = $data->createToken('myapptoken');
            $User = Auth::user();

            return response()->json([
                'data'=>$data,
                'expires_in' => '0',
                'token_type' => 'bearer',
                'access_token' => $dataUser->plainTextToken,
            ]);
        }else{
            return response()->json([
                'error'=> 'errorAuthentication',
                'messageError' => 'Credencias inavalidas'
            ]);
        }

    }

    public function register(Request $request, User $post)
    {

        if(empty($request->first_name) or empty($request->last_name) or empty($request->username) or empty($request->password) or empty($request->confirmpassword) or empty($request->rule)){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Preencha todos os campos.'
                ]);
        }


        if($request->grade != 'User'){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Grade invalido, Preencha todos os campos.'
                ]);
        }

        if(User::where('username','=',$request->username)->exists()){
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Nome de usuario ja existe.'
                ]);

        }else if(User::where('email','=',$request->email)->exists()) {
            return response()->json([
                'error'=> 'errorRegister',
                'messageError' => 'Email ja existe.'
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

    public function reset(Request $request, $id)
    {

        if( empty($request->password) or empty($request->confirmpassword) or empty($request->nova_password) ){
            return response()->json([
                'error'=> 'errorRegister',
                'message' => 'Preencha todos os campos.'
                ]);
        }

        $message = null;
        $user = User::find($id);

        if (Hash::check($request->password, $user->password)) {

            if ($request->nova_password == $request->confirm_password) {

                $novaPassword = Hash::make($request->nova_password);
                $user->update([
                    'password' => $novaPassword,
                ]);
                $message = 'Password alterada.';
            } else {
                $message = 'As credencias não coincidem.';
            }
        } else {
            $message = 'Password invalida.';
        }

        return response()->json([
            'message' => $message,
        ]);
    }

    public function logout() {

        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json('Successfully logged out');
    }
}
