<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;

class VendedorController extends Controller
{
    // Mostra a página de cadastro
    public function create()
    {
        $unidades = \DB::table('unidade')->get();
        $consultores = Consultor::all();

        return view('vendedor.create', compact('unidades', 'consultores'));
    }

    // Armazena um novo vendedor
    public function store(Request $request)
    {
        $data = $request->only(['nome_consultor', 'sobrenome_consultor', 'unidade', 'ativo']);

if ($request->hasFile('foto')) {
    $file = $request->file('foto');
    $filename = time() . '_' . $file->getClientOriginalName();
    // Salva na pasta correta
    $file->move(public_path('storage/fotos_vendedores'), $filename);
    $data['Foto'] = 'storage/fotos_vendedores/' . $filename;
}

        Consultor::create($data);

        return redirect()->back()->with('success', 'Vendedor cadastrado com sucesso!');
    }

    // Atualiza os dados de um vendedor existente
    public function update(Request $request, $id)
    {
        $consultor = Consultor::findOrFail($id);

        $data = $request->only(['nome_consultor', 'sobrenome_consultor', 'unidade', 'ativo']);

    if ($request->hasFile('foto')) {
    $file = $request->file('foto');
    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    $file->move(public_path('storage/fotos_vendedores'), $filename);
    $data['Foto'] = 'storage/fotos_vendedores/' . $filename;
}


        $consultor->update($data);

        return redirect()->back()->with('success', 'Vendedor atualizado com sucesso!');
    }
}
