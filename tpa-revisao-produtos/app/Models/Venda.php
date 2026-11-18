<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venda extends Model
{
    protected $fillable = [
        'cliente_id',
    ];

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class)
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}
