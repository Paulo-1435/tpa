@extends('layouts.app')

@section('title', 'Sobre — Portal de Eventos')

@section('content')
<div class="card shadow-sm p-4">
    <h2 class="fw-bold">Sobre o portal</h2>
    <p class="text-secondary">
        O Portal de Eventos é um projeto didático para treino da disciplina de TPA.
        O site já está pronto: falta implementar as features novas descritas no enunciado do simulado.
    </p>
    <h5 class="fw-bold mt-3">Quem é quem</h5>
    <ul class="text-secondary">
        <li><strong>Organizador:</strong> cadastra Eventos na agenda.</li>
        <li><strong>Participante:</strong> compra ingressos e consulta os próprios pedidos.</li>
        <li><strong>Visitante:</strong> só navega pela agenda.</li>
    </ul>
</div>
@endsection
