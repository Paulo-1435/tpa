<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('eventos')
            ->where('participante_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $eventos = Evento::orderBy('titulo')->get();

        return view('pedidos.create', compact('eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingressos' => ['required', 'array'],
            'ingressos.*' => ['nullable', 'integer', 'min:0'],
        ]);

        // 1. ignora os eventos com quantidade 0
        $ingressos = collect($request->input('ingressos'))
            ->map(fn ($quantidade) => (int) $quantidade)
            ->filter(fn ($quantidade) => $quantidade > 0);

        // 2. sem nenhum evento, volta com erro
        if ($ingressos->isEmpty()) {
            return back()->withInput()->withErrors(['ingressos' => 'Informe a quantidade de pelo menos um evento.']);
        }

        $eventos = Evento::findMany($ingressos->keys())->keyBy('id');

        // Bônus: recusa o pedido se alguma quantidade passar das vagas
        foreach ($ingressos as $eventoId => $quantidade) {
            $evento = $eventos->get($eventoId);

            if (! $evento) {
                return back()->withInput()->withErrors(['ingressos' => 'Evento inválido.']);
            }

            if ($quantidade > $evento->vagas) {
                return back()->withInput()->withErrors([
                    'ingressos' => "Vagas insuficientes para {$evento->titulo} (disponíveis: {$evento->vagas}).",
                ]);
            }
        }

        DB::transaction(function () use ($ingressos, $eventos) {
            // 3. cria o pedido para o usuário logado
            $pedido = Pedido::create(['participante_id' => Auth::id()]);

            // 4. anexa cada evento com a quantidade e o preço atual
            foreach ($ingressos as $eventoId => $quantidade) {
                $evento = $eventos->get($eventoId);

                $pedido->eventos()->attach($evento->id, [
                    'quantidade' => $quantidade,
                    'preco_unitario' => $evento->preco,
                ]);

                // Bônus: baixa as vagas
                $evento->decrement('vagas', $quantidade);
            }
        });

        // 5. redireciona para os pedidos
        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido realizado!');
    }
}
