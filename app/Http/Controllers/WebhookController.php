<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        // 🔎 Loga o que chegou no Laravel (aparece em storage/logs/laravel.log)
        Log::info('Webhook recebido:', $data);

        // Verifica se existe o contato
        $contactData = $data['contact'] ?? null;
        if (!$contactData) {
            return response()->json(['error' => 'Contato não encontrado'], 400);
        }

        // Cria ou atualiza o contato
        $contato = Contato::updateOrCreate(
            ['id_externo' => $contactData['id'] ?? null],
            [
                'nome' => $contactData['name'] ?? null,
                'numero' => $contactData['number'] ?? null,
                'email' => $contactData['email'] ?? null,
                'pushname' => $contactData['pushname'] ?? null,
                'observacoes' => $contactData['observations'] ?? null,
                'campos_personalizados' => isset($contactData['customFields']) 
                    ? json_encode($contactData['customFields']) 
                    : null,
            ]
        );

        return response()->json(['status' => 'ok', 'contato_id' => $contato->id]);
    }
}
