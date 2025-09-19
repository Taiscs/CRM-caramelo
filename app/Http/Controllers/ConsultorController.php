<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\Consultor;

class ConsultorController extends Controller
{
    // Exibe o formulário de cadastro
public function create()
{
    $unidades = Unidade::all(); // pega todas as unidades

    // Pega todos os consultores e adiciona a propriedade 'photo' com URL completa
    $consultores = Consultor::all()->map(function ($c) {
        $c->photo = $c->Foto ? url($c->Foto) : url('assets/default-avatar.png');
        return $c;
    });

    return view('vendedor.create', compact('unidades', 'consultores'));
}

    // Salva os dados do consultor
    public function store(Request $request)
    {
        $request->validate([
            'nome_consultor' => 'required|string|max:50',
            'sobrenome_consultor' => 'required|string|max:150',
            'unidade' => 'required|integer|exists:unidade,ID',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $consultor = new Consultor();
        $consultor->nome_consultor = $request->nome_consultor;
        $consultor->sobrenome_consultor = $request->sobrenome_consultor;
        $consultor->unidade = $request->unidade;
        $consultor->ativo = 1;

        // Upload da foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fotos_vendedores', $filename);
            $consultor->Foto = 'storage/fotos_vendedores/' . $filename;
        }

        $consultor->save();

        return redirect()->route('vendedor.create')->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function updateFoto(Request $request, $id)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $consultor = Consultor::findOrFail($id);

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/fotos_vendedores', $filename);
        $consultor->Foto = 'storage/fotos_vendedores/' . $filename;
        $consultor->save();
    }

    return redirect()->back()->with('success', 'Foto atualizada com sucesso!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nome_consultor' => 'required|string|max:50',
        'sobrenome_consultor' => 'required|string|max:150',
        'unidade' => 'required|integer|exists:unidade,ID',
        'ativo' => 'required|boolean',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $consultor = Consultor::findOrFail($id);
    $consultor->nome_consultor = $request->nome_consultor;
    $consultor->sobrenome_consultor = $request->sobrenome_consultor;
    $consultor->unidade = $request->unidade;
    $consultor->ativo = $request->ativo;

    // Atualiza foto se enviada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/fotos_vendedores', $filename);
        $consultor->Foto = 'storage/fotos_vendedores/' . $filename;
    }

    $consultor->save();

    return redirect()->route('vendedor.create')->with('success', 'Vendedor atualizado com sucesso!');
}


}
