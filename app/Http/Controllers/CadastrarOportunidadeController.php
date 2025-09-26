<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Venda;
use Exception;
use Illuminate\Support\Facades\Log; // Importe a classe Log aqui

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
        try {
            // 1. Validar os dados recebidos do frontend
            $request->validate([
                'clientes_ids' => 'required|array',
                'clientes_ids.*' => 'integer',
                'descricao_oportunidade' => 'required|string',
                'data_oportunidade' => 'required|date',
            ]);
        
            // 2. Encontrar o vendedor mais recente associado a um dos clientes.
            $mostRecentSale = Venda::whereIn('cliente_id', $request->input('clientes_ids'))
                                    ->orderBy('cadastro', 'desc')
                                    ->first();
        
            $vendedorId = null;
            if ($mostRecentSale) {
                $vendedorId = $mostRecentSale->vendedor_id;
            } else {
                // Caso não encontre, atribui um ID padrão.
                $vendedorId = 1;
            }
        
            // 3. Salvar uma nova oportunidade para CADA cliente da lista
            foreach ($request->input('clientes_ids') as $clienteId) {
                // Verifique se os campos estão em seu modelo 'Oportunidade.php'.
                Oportunidade::create([
                    'vendedor_id' => $vendedorId,
                    'cliente_id' => $clienteId,
                    'descricao_oportunidade' => $request->input('descricao_oportunidade'),
                    'data_oportunidade' => $request->input('data_oportunidade'),
                ]);
            }
        
            return response()->json([
                'message' => 'Oportunidades criadas com sucesso!',
            ], 201);
            
        } catch (Exception $e) {
            // Esta linha irá registrar o erro detalhado no seu arquivo de log do Laravel.
            Log::error('Erro ao salvar oportunidades: ' . $e->getMessage(), [
                'stack_trace' => $e->getTraceAsString(),
                'request_body' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'Erro ao salvar oportunidades: ' . $e->getMessage(),
            ], 400);
        }
    }
}
