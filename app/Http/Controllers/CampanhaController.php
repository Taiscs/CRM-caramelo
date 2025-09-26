<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JetsalesService;

class CampanhaController extends Controller
{
public function index(JetsalesService $jetsales)
{
    try {
        $campaigns = $jetsales->getCampaigns();

        // transforma em collection e mapeia
        $campaigns = collect($campaigns)->map(function ($campaign) {
            // Traduz status
            $statusMap = [
                'active' => 'Ativa',
                'inactive' => 'Inativa',
                'draft' => 'Rascunho',
                'paused' => 'Pausada',
                'completed' => 'Concluída',
                'Finished' => 'Finalizada',
                'Pending'=> 'Pendente',
            ];

            $campaign['status_pt'] = $statusMap[strtolower($campaign['status'] ?? '')] 
                                      ?? ucfirst($campaign['status'] ?? 'Desconhecido');

            return $campaign;
        });

    } catch (\Exception $e) {
        \Log::error("Erro ao buscar campanhas: " . $e->getMessage());
        $campaigns = collect();
    }

    return view('campanhas', compact('campaigns'));
}

}
