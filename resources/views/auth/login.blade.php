<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login | Mundo Caramelo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background: linear-gradient(135deg, #ffe9ec, #fdf6e3);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
  }
  .login-card {
    background-color: #fffaf3;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0 15px rgba(255, 184, 184, 0.2);
    max-width: 400px;
    width: 100%;
  }
  .login-card h2 {
    color: #a45d5d;
    text-align: center;
    margin-bottom: 1rem;
  }
  .logo {
    width: 100px;
    height: 100px; /* Adicione altura igual à largura para um círculo perfeito */
    border-radius: 50%; /* Faz a imagem circular */
    object-fit: cover; /* Garante que a imagem preencha o círculo sem distorcer */
    display: block;
    margin: 0 auto 1rem;
  }
  .btn-caramelo {
    background-color: #f9b88d;
    border: none;
    color: #fff;
  }
  .btn-caramelo:hover {
    background-color: #f1a16d;
  }
</style>
</head>
<body>
  <div class="login-card">
    <img src="{{ asset('img/logo.png') }}" alt="Logo Mundo Caramelo" class="logo">
    <h2>Bem-vindo!</h2>

    {{-- Exibe erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger text-center p-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf {{-- Token CSRF essencial para segurança no Laravel --}}
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuário</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="usuario" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" class="form-control @error('senha') is-invalid @enderror" id="senha" name="senha" required>
        @error('senha')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-caramelo">Entrar</button>
      </div>
    </form>
  </div>

  {{-- O modal de erro não é mais controlado por PHP diretamente na view, mas sim pela lógica do Laravel --}}
  {{-- O Bootstrap 5 já tem seu próprio mecanismo para exibir modais com classes JS --}}
  {{-- Você precisaria de um script JS para acionar o modal se houver erros, mas o redirecionamento com `withErrors` é mais comum --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>