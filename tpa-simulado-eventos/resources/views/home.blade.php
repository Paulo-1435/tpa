@extends('layouts.app')

@section('content')
<div class="card shadow-sm p-5 mb-4">
    <h1 class="fw-bold">Bem-vindo ao Portal de Eventos 🎟️</h1>
    <p class="lead text-secondary mb-4">
        Uma bilheteria simples: organizadores cadastram Eventos e participantes compram ingressos.
    </p>
    <div>
        <a href="{{ route('eventos.index') }}" class="btn btn-primary btn-lg me-2">Ver Eventos</a>
        <a href="{{ route('pedidos.create') }}" class="btn btn-outline-light btn-lg">Comprar ingressos</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card h-100 p-3">
            <h5 class="fw-bold">🎤 Para organizadores</h5>
            <p class="text-secondary mb-0">Entre com sua conta de organizador e cadastre novos eventos na agenda.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 p-3">
            <h5 class="fw-bold">🎟️ Para participantes</h5>
            <p class="text-secondary mb-0">Escolha um ou mais eventos, informe quantos ingressos quer e finalize o pedido.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 p-3">
            <h5 class="fw-bold">🧾 Histórico</h5>
            <p class="text-secondary mb-0">Acompanhe em "Meus pedidos" todos os ingressos que você já comprou, com o total de cada pedido.</p>
        </div>
    </div>
</div>
@endsection
