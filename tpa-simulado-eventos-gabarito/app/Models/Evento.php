<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    protected $fillable = [
        'titulo',
        'categoria',
        'duracao_minutos',
        'preco',
        'vagas',
    ];

    public function organizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizador_id');
    }
}
