<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FonteCapitacaoController extends Controller
{
    public function listarFontes()
    {
        try {
            $fontes = DB::table('fonte_capitacao')->select('id_fonte', 'nome')->get();
            return response()->json($fontes);
        } catch (\Exception $e) {
            return response()->json(['erro' => $e->getMessage()], 500);
        }
    }
}
