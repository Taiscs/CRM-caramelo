<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampanhaController extends Controller
{
    /**
     * Exibe a página de gestão de campanhas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('campanhas'); // Retorna a view campanhas.blade.php
    }
}