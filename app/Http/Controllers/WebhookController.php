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

        // 🔎 Logar todo o payload que chegou
        Log::info('Webhook recebido:', $data);

        // Agora os dados já estão na raiz
        $contato = Contato::updateOrCreate(
            ['id_externo' => $data['id'] ?? null],
            [
                'nome' => $data['name'] ?? null,
                'numero' => $data['number'] ?? null,
                'email' => $data['email'] ?? null,
                'pushname' => $data['pushname'] ?? null,
                'observacoes' => $data['observations'] ?? null,
                'campos_personalizados' => isset($data['customFields'])
                    ? json_encode($data['customFields'])
                    : null,
            ]
        );

        return response()->json(['status' => 'ok', 'contato_id' => $contato->id]);
    }
}
