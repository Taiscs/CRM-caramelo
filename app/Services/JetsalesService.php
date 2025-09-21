<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class JetsalesService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('JETSALES_API_URL'), '/');
    }

    /**
     * Faz login e salva o token no cache
     */
    public function authenticate(): ?string
    {
        $response = Http::post("{$this->baseUrl}/auth/login", [
            'email' => env('JETSALES_API_USER'),
            'password' => env('JETSALES_API_PASSWORD')
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Confirma se a API devolveu um token válido
            $token = $data['token'] ?? null;

            if ($token) {
                // Salva no cache por 50 minutos (antes do expirar real de 1h)
                Cache::put('jetsales_token', $token, now()->addMinutes(50));
                return $token;
            }
        }

        return null;
    }

    /**
     * Retorna o token válido, autenticando se necessário
     */
    public function getToken(): ?string
    {
        $token = Cache::get('jetsales_token');

        if (!$token) {
            $token = $this->authenticate();
        }

        return $token;
    }

    /**
     * Faz requisições autenticadas à API
     */
    public function get(string $endpoint, array $params = []): ?array
    {
        $token = $this->getToken();

        if (!$token) {
            throw new \Exception("Falha ao obter token da Jetsales");
        }

        $response = Http::withToken($token)->get("{$this->baseUrl}/{$endpoint}", $params);

        // Se o token expirou, tenta renovar automaticamente
        if ($response->status() === 401) {
            $token = $this->authenticate();
            if (!$token) {
                throw new \Exception("Não foi possível renovar o token da Jetsales");
            }

            $response = Http::withToken($token)->get("{$this->baseUrl}/{$endpoint}", $params);
        }

        return $response->successful() ? $response->json() : null;
    }
}
