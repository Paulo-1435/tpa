<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * CONTRATO DA Q1: este seeder define o nome da model (Evento), da tabela
 * (eventos) e das colunas. Sua migration e sua model precisam ser
 * compatíveis com ele. Não altere este arquivo.
 */
class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            ['titulo' => 'Show de Rock Nacional', 'categoria' => 'Show', 'duracao_minutos' => 180, 'preco' => 120.0, 'vagas' => 40],
            ['titulo' => 'Peça: O Auto da Compadecida', 'categoria' => 'Teatro', 'duracao_minutos' => 110, 'preco' => 60.0, 'vagas' => 25],
            ['titulo' => 'Palestra: Carreira em TI', 'categoria' => 'Palestra', 'duracao_minutos' => 90, 'preco' => 0.0, 'vagas' => 100],
            ['titulo' => 'Final do Campeonato de Vôlei', 'categoria' => 'Esporte', 'duracao_minutos' => 150, 'preco' => 35.5, 'vagas' => 8],
            ['titulo' => 'Festival de Jazz', 'categoria' => 'Show', 'duracao_minutos' => 240, 'preco' => 89.9, 'vagas' => 15],
        ];

        $colunas = [...array_keys($eventos[0]), 'organizador_id'];

        if (! class_exists(Evento::class) || ! Schema::hasColumns('eventos', $colunas)) {
            $this->command->warn('Eventos não semeados: faça a Q1 (model Evento + migration com as colunas '
                . implode(', ', $colunas) . ') e rode "php artisan migrate:fresh --seed".');

            return;
        }

        $organizadores = User::where('tipo', 'organizador')->orderBy('id')->pluck('id');

        foreach ($eventos as $i => $dados) {
            Evento::forceCreate($dados + ['organizador_id' => $organizadores[$i % $organizadores->count()]]);
        }
    }
}
