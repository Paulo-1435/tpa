<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('vendedor')->get();

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(StoreProdutoRequest $request)
    {
        $produto = new Produto($request->validated());
        $produto->vendedor_id = Auth::id();
        $produto->save();

        return redirect()->route('produtos.index')->with('sucesso', 'Produto cadastrado!');
    }
}
