<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Se for usar verificação de e-mail
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login'; // <--- Aponta para a tabela 'login'

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario'; // <--- Sua chave primária na tabela 'login'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_usuario', // Inclua a PK se for preenchida massivamente
        'login',      // O campo que você usa para login (email)
        'senha',      // O campo de senha
        // Você pode precisar adicionar outros campos aqui se eles existirem na sua tabela 'login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token', // Se você tiver um campo 'remember_token' na sua tabela 'login'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime', // Se tiver campo de verificação de e-mail
        'password' => 'hashed', // Laravel 10+ automaticamente hasheia/verifica senhas. Mude 'password' para 'senha'.
                                // No entanto, como você está usando 'senha' no controlador, pode não ser necessário aqui se a senha já vem hash
    ];

    // Mapeia o campo 'login' para o 'email' que o sistema de autenticação do Laravel espera.
    // Isso é útil se o seu campo de usuário não é chamado 'email'.
    public function getEmailAttribute()
    {
        return $this->login;
    }

    // Relacionamento com a tabela 'usuarios' para pegar a 'role'
    public function usuarioDetalhes()
    {
        return $this->hasOne(Usuario::class, 'id', 'id_usuario'); // Assumindo que 'usuarios.id' e 'login.id_usuario' se relacionam
    }

    // Sobrescreve o método getAuthPassword() para usar o campo 'senha'
    public function getAuthPassword()
    {
        return $this->senha;
    }

    // Adiciona o accesor para a 'role'
    public function getRoleAttribute()
    {
        // Se você já buscou a role no login controller, pode não precisar aqui.
        // Mas se quiser que o modelo sempre tenha acesso à role:
        return $this->usuarioDetalhes->role ?? null;
    }
}

// app/Models/Usuario.php (Crie este novo arquivo, se necessário, para a tabela 'usuarios')
// php artisan make:model Usuario
// E então edite-o:

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios'; // Aponta para a tabela 'usuarios'
    protected $primaryKey = 'id'; // Sua chave primária na tabela 'usuarios'

    protected $fillable = [
        'role', // e outros campos da tabela usuarios
    ];

    // Se tiver um relacionamento inverso (usuário tem login)
    public function loginDetails()
    {
        return $this->belongsTo(User::class, 'id', 'id_usuario'); // 'id' da tabela 'usuarios', 'id_usuario' da tabela 'login'
    }
}