<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VendedorController extends Controller
{
    // Mostra a página de cadastro
    public function create()
    {
        $unidades = DB::table('unidade')->get();
        $consultores = Consultor::all();

        return view('vendedor.create', compact('unidades', 'consultores'));
    }

    // Armazena um novo vendedor
    public function store(Request $request)
    {
        $data = $request->only(['nome_consultor', 'sobrenome_consultor', 'unidade', 'ativo']);
        $data['foto'] = null; // Inicializa com null

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Remove espaços do nome do arquivo para evitar problemas
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            // Salva na pasta correta
            $file->move(public_path('storage/fotos_vendedores'), $filename);
            $data['foto'] = 'storage/fotos_vendedores/' . $filename;
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
            // Deleta a foto antiga se ela existir e for diferente do padrão
            if ($consultor->foto && strpos($consultor->foto, 'default-avatar.png') === false) {
                $caminhoAntigo = public_path($consultor->foto);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/fotos_vendedores'), $filename);
            $data['foto'] = 'storage/fotos_vendedores/' . $filename;
        }


        $consultor->update($data);

        return redirect()->back()->with('success', 'Vendedor atualizado com sucesso!');
    }
}