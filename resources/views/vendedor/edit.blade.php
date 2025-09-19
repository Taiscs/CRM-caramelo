@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Editar Vendedor</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('vendedor.update', $consultor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome_consultor" class="form-label">Nome</label>
            <input type="text" name="nome_consultor" class="form-control" value="{{ $consultor->nome_consultor }}" required>
        </div>

        <div class="mb-3">
            <label for="sobrenome_consultor" class="form-label">Sobrenome</label>
            <input type="text" name="sobrenome_consultor" class="form-control" value="{{ $consultor->sobrenome_consultor }}" required>
        </div>

        <div class="mb-3">
            <label for="unidade" class="form-label">Unidade</label>
            <select name="unidade" class="form-select" required>
                @foreach($unidades as $unidade)
                    <option value="{{ $unidade->ID }}" {{ $consultor->unidade == $unidade->ID ? 'selected' : '' }}>
                        {{ $unidade->NOME }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ativo" class="form-label">Ativo</label>
            <select name="ativo" class="form-select" required>
                <option value="1" {{ $consultor->ativo ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ !$consultor->ativo ? 'selected' : '' }}>Não</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto do Vendedor</label>
            @if($consultor->Foto)
                <div class="mb-2">
                    <img src="{{ asset($consultor->Foto) }}" alt="Foto do Vendedor" style="width:100px;height:100px;object-fit:cover;border-radius:50%;">
                </div>
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
