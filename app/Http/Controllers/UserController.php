<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conta;
use App\Models\Corrida;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function InserirUsuario(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:155',
            'email' => 'required|string|max:155',
            'password' => 'required|string|max:155'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "corrida" => "Dados inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }



        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "",
                "user_id" => "Cliente cadastrado anteriormente",
                "valor" => "",
                "msg"=>""
            ]);

        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = 1;
        $user->password = md5($request->email);
        $user->created_at = date("Y-m-d");
        $user->save();

        $conta = new Conta();
        $conta->saldo = 0;
        $conta->user_id = $user->id;
        $conta->save();

        return response()->json([
            "result"=>"1",
            "status"=>"Ok",
            "usuario" => "Ok",
            "user_id" => $user->id,
            "saldo" => 0,
            "msg"=>"Usuario criado com sucesso"
        ]);
    }

    public function DadosUsuario(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:155'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "corrida" => "Dados inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }



        if (!User::where('email', $request->email)->exists()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "",
                "user_id" => "Cliente inexistente",
                "valor" => "",
                "msg"=>""
            ]);

        }

        $user = User::where('email', $request->email)->first();
        $conta = Conta::where('user_id', $user->id)->first();

        return response()->json([
            "result"=>"1",
            "status"=>"Ok",
            "usuario" => "Ok",
            "user_id" => $user,
            "saldo" => $conta->saldo,
            "msg"=>"Usuario criado com sucesso"
        ]);
    }

    public function cadastrarUsuario(string $nome, string $email)
    {

        $user = new User();

        $user->name = $nome;
        $user->email = $email;
        $user->status = 1;
        $user->password = md5("secret123");
        $user->created_at = date("Y-m-d");
        $user->save();
        return true;

    }

}
