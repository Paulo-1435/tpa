<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoRequest;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with('organizador')->orderBy('titulo')->get();

        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(StoreEventoRequest $request)
    {
        $evento = new Evento($request->validated());
        $evento->organizador_id = Auth::id();
        $evento->save();

        return redirect()->route('eventos.index')->with('sucesso', 'Evento cadastrado!');
    }
}
