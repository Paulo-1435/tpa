<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| GUIA – por onde começar (Q1)
|--------------------------------------------------------------------------
| Antes de mexer neste controller, crie a model e a migration:
|
|   php artisan make:model Evento -m
|
| Na migration (database/migrations/..._create_eventos_table.php), crie as
| colunas da tabela de contratos do README:
|   - titulo e categoria  -> $table->string(...)
|   - duracao_minutos e vagas -> $table->integer(...)
|   - preco -> $table->decimal('preco', 8, 2)
|   - organizador_id -> $table->foreignId('organizador_id')->constrained('users')
|
| Na model (app/Models/Evento.php):
|   - $fillable com titulo, categoria, duracao_minutos, preco, vagas
|     (NÃO coloque organizador_id: ele é definido pelo sistema na Q6)
|   - método organizador() devolvendo
|     $this->belongsTo(User::class, 'organizador_id')
|     (o segundo argumento é obrigatório: sem ele o Laravel procuraria
|     a coluna "user_id")
|
| Confira com: php artisan migrate:fresh --seed
| O aviso "Eventos não semeados" tem que sumir.
*/
class EventoController extends Controller
{
    /*
     * Q1 – Agenda pública
     *
     * 1. Importe a model no topo: use App\Models\Evento;
     * 2. Busque os eventos já com o organizador carregado e em ordem
     *    alfabética: Evento::with('organizador')->orderBy('titulo')->get()
     *    - with() evita uma consulta por linha da tabela (problema N+1)
     * 3. Devolva a view 'eventos.index' passando a variável $eventos
     *    (a view espera exatamente esse nome): view('...', compact('eventos'))
     */
    public function index()
    {
        //
    }

    public function create()
    {
        return view('eventos.create');
    }

    /*
     * Q5 – Cadastro validado
     *
     * 1. Crie o FormRequest: php artisan make:request StoreEventoRequest
     * 2. Em app/Http/Requests/StoreEventoRequest.php:
     *    - authorize() deve devolver true (o padrão é false e dá 403!)
     *    - rules() devolve um array campo => regras. Regras úteis:
     *      required, string, integer, numeric, min:N, max:N,
     *      between:A,B e in:Valor1,Valor2
     *      Atenção: "min" em texto conta caracteres; em número
     *      (com integer/numeric) compara o valor.
     *    - o preço pode ser 0, então use min:0 e não gt:0
     * 3. Troque "Request $request" por "StoreEventoRequest $request" na
     *    assinatura deste método e importe a classe no topo. A validação
     *    passa a rodar sozinha antes de o método ser executado.
     * 4. Os dados já validados vêm de $request->validated()
     *
     * Q6 – Dono do evento
     *
     * 5. Não use Evento::create() direto com o formulário, porque falta o
     *    organizador_id. Um caminho:
     *      $evento = new Evento($request->validated());
     *      $evento->organizador_id = Auth::id();
     *      $evento->save();
     *    (importe use Illuminate\Support\Facades\Auth;)
     *
     * 6. Redirecione para a agenda com a mensagem de sucesso:
     *    redirect()->route('eventos.index')->with('sucesso', 'Evento cadastrado!')
     *    A chave tem que ser 'sucesso': é a que o layout mostra.
     */
    public function store(Request $request)
    {
        //
    }
}
