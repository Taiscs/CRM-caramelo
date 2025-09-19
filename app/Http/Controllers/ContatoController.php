<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContatoController extends Controller
{
    public function receberWebhook(Request $request)
    {
        // Pega os dados do JSON
        $data = $request->json()->all();

        // Log completo do JSON recebido
        Log::info('=== Webhook recebido ===');
        Log::info($data);

        // Aceita tanto "numero" quanto "number"
        $numero = $data['numero'] ?? $data['number'] ?? null;
        $nome   = $data['nome'] ?? $data['name'] ?? null;

        if (!$numero) {
            Log::warning('Número de telefone ausente no webhook.');
            return response()->json(['erro' => 'Número de telefone obrigatório.'], 400);
        }

        // Procura contato existente
        $contato = Contato::where('numero', $numero)->first();

        if ($contato) {
            Log::info("Contato encontrado no banco. ID: {$contato->id}");
            
            $contato->update([
                'nome' => $nome ?? $contato->nome,
                'email' => $data['email'] ?? $contato->email,
                'pushname' => $data['pushname'] ?? $contato->pushname,
                'observacoes' => $data['observations'] ?? $contato->observacoes,
                'campos_personalizados' => json_encode($data['customFields'] ?? $contato->campos_personalizados),
            ]);

            Log::info("Contato atualizado com sucesso. ID: {$contato->id}");
            return response()->json(['mensagem' => 'Contato atualizado com sucesso.'], 200);
        }

        // Cria novo contato
        $novoContato = Contato::create([
            'id_externo' => $data['id'] ?? null,
            'nome' => $nome,
            'numero' => $numero,
            'email' => $data['email'] ?? null,
            'pushname' => $data['pushname'] ?? null,
            'observacoes' => $data['observations'] ?? null,
            'campos_personalizados' => json_encode($data['customFields'] ?? '{}'),
        ]);

        Log::info("Novo contato criado. ID: {$novoContato->id}");

        return response()->json([
            'mensagem' => 'Novo contato criado com sucesso.',
            'id' => $novoContato->id
        ], 201);
    }
}
