<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'min:3', 'max:100'],
            'categoria' => ['required', 'in:Show,Teatro,Palestra,Esporte'],
            'duracao_minutos' => ['required', 'integer', 'between:30,480'],
            'preco' => ['required', 'numeric', 'min:0'],
            'vagas' => ['required', 'integer', 'min:1'],
        ];
    }
}
