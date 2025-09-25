<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Venda;

class CadastrarOportunidadeController extends Controller
{
    /**
     * Recebe dados do formulário de oportunidade e cria um novo registro
     * para cada cliente. O id_vendedor é buscado automaticamente.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOpportunity(Request $request)
    {
        // 1. Validar os dados recebidos do frontend
        $request->validate([
            'clientes_ids' => 'required|array',
            'clientes_ids.*' => 'integer',
            'descricao_oportunidade' => 'required|string',
            'data_oportunidade' => 'required|date',
        ]);
    
        // 2. Encontrar o vendedor mais recente associado a um dos clientes.
        // Isso garante que apenas uma busca seja feita antes do loop.
        $mostRecentSale = Venda::whereIn('cliente_id', $request->input('clientes_ids'))
                                        ->orderBy('data_venda', 'desc')
                                        ->first();
    
        $vendedorId = null;
        if ($mostRecentSale) {
            $vendedorId = $mostRecentSale->vendedor_id;
        } else {
            // Se nenhum registro de venda for encontrado, defina um vendedor padrão.
            // Altere o valor '1' para o ID do vendedor padrão desejado.
            $vendedorId = 1;
        }
    
        // 3. Salvar uma nova oportunidade para CADA cliente da lista
        foreach ($request->input('clientes_ids') as $clienteId) {
            $oportunidade = Oportunidade::create([
                'vendedor_id' => $vendedorId,
                'cliente_id' => $clienteId,
                'descricao_oportunidade' => $request->input('descricao_oportunidade'),
                'data_oportunidade' => $request->input('data_oportunidade'),
            ]);
        }
    
        return response()->json([
            'message' => 'Oportunidades criadas com sucesso!',
        ], 201);
    }
}
