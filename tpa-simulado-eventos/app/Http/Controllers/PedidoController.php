<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| GUIA – antes de mexer neste controller (Q7)
|--------------------------------------------------------------------------
| 1. Crie a model com a migration:  php artisan make:model Pedido -m
|    Tabela "pedidos": id, participante_id (foreignId -> users), timestamps.
|
| 2. Crie a migration da pivô:
|      php artisan make:migration create_evento_pedido_table
|    O nome é "evento_pedido" porque o Laravel junta os dois nomes no
|    singular e em ORDEM ALFABÉTICA (evento vem antes de pedido).
|    Colunas: id, pedido_id e evento_id (foreignId + constrained),
|    quantidade (integer), preco_unitario (decimal 8,2), timestamps.
|    Confira que essa migration roda DEPOIS das de eventos e de pedidos
|    (a ordem é a da data no nome do arquivo).
|
| 3. Em app/Models/Pedido.php:
|    - $fillable = ['participante_id']
|    - relação eventos():
|        return $this->belongsToMany(Evento::class)
|            ->withPivot('quantidade', 'preco_unitario')
|            ->withTimestamps();
|      Sem withPivot() a view não consegue ler $evento->pivot->quantidade.
|
| 4. Rode: php artisan migrate:fresh --seed
*/
class PedidoController extends Controller
{
    /*
     * Q8 – Meus pedidos
     *
     * 1. Busque só os pedidos de quem está logado:
     *    Pedido::where('participante_id', Auth::id())
     * 2. Carregue os eventos junto: ->with('eventos')
     * 3. Do mais recente para o mais antigo: ->latest() ou ->orderByDesc('id')
     * 4. Termine com ->get() e devolva a view 'pedidos.index' com $pedidos
     *
     * Se esquecer o where, o Davi vai enxergar os pedidos da Clara e a
     * questão não pontua.
     */
    public function index()
    {
        //
    }

    // Já está pronto. Só funciona depois que a model Evento existir (Q1).
    public function create()
    {
        $eventos = Evento::orderBy('titulo')->get();

        return view('pedidos.create', compact('eventos'));
    }

    /*
     * Q7 – Pedido de ingressos
     *
     * O formulário envia um array no formato  ingressos[id_do_evento] = quantidade,
     * por exemplo: ['1' => '3', '2' => '0', '5' => '1'].
     *
     * 1. Leia o array e tire as quantidades 0:
     *    $ingressos = collect($request->input('ingressos', []))
     *        ->map(fn ($qtd) => (int) $qtd)
     *        ->filter(fn ($qtd) => $qtd > 0);
     *    Agora a chave é o id do evento e o valor é a quantidade.
     *
     * 2. Se não sobrou nada ($ingressos->isEmpty()), volte com erro:
     *    return back()->withErrors(['ingressos' => 'Escolha pelo menos um evento.']);
     *
     * 3. Busque os eventos escolhidos de uma vez:
     *    $eventos = Evento::findMany($ingressos->keys());
     *
     * 4. (BÔNUS) Antes de criar qualquer coisa, percorra os eventos e, se
     *    a quantidade pedida for maior que $evento->vagas, volte com erro.
     *    Essa checagem tem que vir ANTES do passo 5; senão você cria um
     *    pedido pela metade.
     *
     * 5. Crie o pedido:
     *    $pedido = Pedido::create(['participante_id' => Auth::id()]);
     *
     * 6. Para cada evento, grave a linha na pivô:
     *    $pedido->eventos()->attach($evento->id, [
     *        'quantidade' => $ingressos[$evento->id],
     *        'preco_unitario' => $evento->preco,   // preço de agora
     *    ]);
     *    (BÔNUS) e baixe as vagas: $evento->decrement('vagas', $quantidade);
     *
     * 7. Redirecione:
     *    redirect()->route('pedidos.index')->with('sucesso', 'Pedido realizado!')
     *
     * Imports necessários no topo: App\Models\Pedido e
     * Illuminate\Support\Facades\Auth.
     *
     * Opcional (boa prática): envolver os passos 5 e 6 em
     * DB::transaction(function () { ... }) para não sobrar pedido
     * incompleto se algo falhar no meio.
     */
    public function store(Request $request)
    {
        //
    }
}
