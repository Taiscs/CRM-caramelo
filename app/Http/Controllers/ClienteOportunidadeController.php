<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteOportunidadeController extends Controller
{
    /**
     * Retorna a lista completa de clientes em formato JSON para uso em API.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Pega todos os clientes do banco de dados e retorna-os como JSON
        $clientes = Cliente::all(); 
        
        return response()->json($clientes);
    }
}
