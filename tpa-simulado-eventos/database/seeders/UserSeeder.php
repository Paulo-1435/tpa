<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Alice Organizadora', 'email' => 'alice@eventos.test', 'tipo' => 'organizador'],
            ['name' => 'Bento Organizador',  'email' => 'bento@eventos.test', 'tipo' => 'organizador'],
            ['name' => 'Clara Participante', 'email' => 'clara@eventos.test', 'tipo' => 'participante'],
            ['name' => 'Davi Participante',  'email' => 'davi@eventos.test',  'tipo' => 'participante'],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario + ['password' => 'senha123']);
        }
    }
}
