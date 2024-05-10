<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginLaravel(Request $request)
    {
        # validar
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        #capturar credenciales
        $credenciales = request(["email", "password"]);
        if (!Auth::attempt($credenciales)) {
            return response()->json(["mensaje" => "Credenciales no son válidas"], 401);
        }

        #Generar Token
        $user = $request->user();
        $tokenResult = $user->createToken('PersonalToken');
        $token = $tokenResult->plainTextToken;
        return response()->json(["access_token" => $token, "token_type" => "Bearer"],);
    }

    public function registro(Request $request)
    {
        //Validar
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users|email",
            "password" => "required",
            "c_password" => "required|same:password",
        ]);

        //Guardar
        //$user = new User($request->all());
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //retornar mensaje
        return response()->json(["mensaje" => "Usuario Registrado"]);
    }

    public function perfil()
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(["mensaje" => "Usuario Salio del Sistema Ñandú"]);
    }
}
