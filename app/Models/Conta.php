<?php
namespace App\Models;

/**
 * Created by Paulo Sergio.
 */

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
	protected $table = 'contas';
	protected $guarded = [''];
	private string $saldo;
	private string $pendencia;

	public function setSaldo(String $saldo){
		$this->saldo = $saldo;
	}

	public function setPendencia(String $pendencia){
		$this->pendencia = $pendencia;
	}

	public function getSaldo(){
		return $this->saldo;
	}

	public function getPendencia(){
		return $this->pendencia;
	}

}
