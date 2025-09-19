<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OportunidadeController extends Controller
{
    public function index()
    {
        return view('oportunidades'); // Retorna a view oportunidades.blade.php
    }
}