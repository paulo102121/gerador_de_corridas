<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Corrida;
use Illuminate\Support\Facades\Validator;


class CorridaController extends Controller
{
    
    public function CancelarCorrida(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:55',
            'obs' => 'required|string|max:255',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                "result"=>"0",
                "status"=>"Recusado",
                "corrida" => "Valores inexistentes",
                "user_id" => "",
                "valor" => "",
                "msg"=>"Algus dados em falta"
            ]);
        }
       
        $corrida = Corrida::find($request->id);
        $corrida->obs = $request->obs;
        $corrida->status = 0;
        $corrida->updated_at = date("Y-m-d");
        $corrida->save();
        
        return response()->json([
            "result"=>"1",
            "status"=>"Cancelado",
            "corrida" => $corrida->id,
            "user_id" => $corrida->user_id,
            "valor" => $corrida->valor,
            "msg"=>"Corrida cancelada com sucesso"
        ]);
    }
  
    
    public function CriarCorrida(Request $request)
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
                "corrida" => "Valores inexistentes",
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
                "user_id" => "Cliente com saldo inexistente",
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
        endif;


        $corrida = new Corrida();
        
        $corrida->valor = round($request->valor, 2);
        $corrida->obs = $request->obs;
        $corrida->status = 1;
        $corrida->created_at = date("Y-m-d");
        $corrida->user_id = $request->user_id;
        $corrida->save();

        $conta->saldo = ($conta->saldo-$request->valor);
        $conta->save();
        
        return response()->json([
            "result"=>"1",
            "status"=>$corrida->status==1?"Ativo":"Cancelado",
            "corrida" => $corrida->id,
            "user_id" => $corrida->user_id,
            "valor" => $corrida->valor,
            "msg"=>"Corrida criada com sucesso"
        ]);
    }
}
