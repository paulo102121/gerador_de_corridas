<?php

namespace Tests;

use App\Http\Controllers\UserController;

class ContaTest extends TestCase
{

    public function testCadastrarUsuario()
    {
        $cadastro = new UserController();
        $resultado = $cadastro->cadastrarUsuario("Paulo2121", "paulovieeum@gmail.com");
        $this->assertTrue($resultado);
    }

}