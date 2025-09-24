@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Cadastrar Vendedor</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulário de cadastro -->
    <form action="{{ route('vendedor.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nome_consultor" class="form-label">Nome</label>
            <input type="text" name="nome_consultor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="sobrenome_consultor" class="form-label">Sobrenome</label>
            <input type="text" name="sobrenome_consultor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="unidade" class="form-label">Unidade</label>
            <select name="unidade" class="form-select" required>
                @foreach($unidades as $unidade)
                    <option value="{{ $unidade->ID }}">{{ $unidade->NOME }}</option>
                @endforeach
            </select>
        </div>

        
        <div class="mb-3">
                
         <select name="ativo" class="form-select mb-2" required>
            <option value="1" >Ativo</option>
            <option value="0">Inativo</option>
        </select>

     </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto do Vendedor</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <hr>

    <!-- Lista de vendedores existentes -->
    <h4 class="mt-4">Vendedores Cadastrados</h4>
    <div class="row">
        @foreach($consultores as $consultor)
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                   <img src="{{ $consultor->foto ? asset($consultor->foto) : asset('storage/fotos_vendedores/default-avatar.png') }}" 
                        class="card-img-top rounded-circle mx-auto mt-3" 
                        style="width: 100px; height: 100px; object-fit: cover;">

                    <div class="card-body">
                        <form action="{{ route('vendedor.update', $consultor->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="text" name="nome_consultor" class="form-control mb-2" value="{{ $consultor->nome_consultor }}" required>
                            <input type="text" name="sobrenome_consultor" class="form-control mb-2" value="{{ $consultor->sobrenome_consultor }}" required>

                            <select name="unidade" class="form-select mb-2" required>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->ID }}" {{ $consultor->unidade == $unidade->ID ? 'selected' : '' }}>
                                        {{ $unidade->NOME }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="ativo" class="form-select mb-2" required>
                                <option value="1" {{ $consultor->ativo ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ !$consultor->ativo ? 'selected' : '' }}>Inativo</option>
                            </select>

                            <input type="file" name="foto" class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
