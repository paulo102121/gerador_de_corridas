<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Corrida;
use Illuminate\Support\Facades\Validator;


class ContaController extends Controller
{
    
   

    public function CheckSaldo(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:55'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "Valores inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }
        
        if (Conta::where('user_id', $request->user_id)->exists()) {
            $conta = Conta::where('user_id', $request->user_id)->first();
        }else{
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "",
                "user_id" => "Cliente inexistente",
                "valor" => "",
                "msg"=>""
            ]);
        }

        return response()->json([
            "result"=>"1",
            "status"=>[],
            "conta" => $conta->id,
            "user_id" => $conta->user_id,
            "valor" => $conta->saldo,
            "msg"=>"Saldo localizado"
        ]);
    }
    
    public function UserHasSaldo(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:55'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "Valores inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }
        
        if (Conta::where('user_id', $request->user_id)->exists()) {
            $conta = Conta::where('user_id', $request->user_id)->first();
        }else{
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "",
                "user_id" => "Cliente inexistente",
                "valor" => "",
                "msg"=>""
            ]);
        }
        
        if ($request->valor > $conta->saldo):
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Saldo insuficiente"
            ]);
        else:
            
            
            return response()->json([
                "result"=>"1",
                "status"=>"Cancelado",
                "conta" => $conta->id,
                "user_id" => $conta->user_id,
                "valor" => $conta->saldo,
                "msg"=>"Saldo suficiente para essa corrida"
            ]);
        endif;
    }

    public function InserirValor(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'valor' => 'required|string|max:55',
            'user_id' => 'required',
            'obs' => 'required|string|max:255',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "conta" => "Valores inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }




        if (Conta::where('user_id', $request->user_id)->exists()) {
            $conta = Conta::where('user_id', $request->user_id)->first();
            $conta->saldo =intval($request->valor)+intval($conta->saldo);
        }else{
            $conta = new Conta();
            $conta->saldo =intval($request->valor);
        }



        $conta->obs = $request->obs;
        $conta->created_at = date("Y-m-d");
        $conta->user_id = $request->user_id;
        $conta->save();
        
        return response()->json([
            "result"=>"1",
            "status"=>[],
            "conta" => $conta->id,
            "user_id" => $conta->user_id,
            "valor" => $conta->saldo,
            "msg"=>"Valor inserido com sucesso"
        ]);
    }
    
    
    
}
