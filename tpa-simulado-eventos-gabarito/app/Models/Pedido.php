<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    protected $fillable = [
        'participante_id',
    ];

    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class)
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}
