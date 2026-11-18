@extends('layouts.app')

@section('title', 'Cadastrar Evento — Portal de Eventos')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm p-4">
            <h3 class="fw-bold mb-3">➕ Cadastrar Evento</h3>
            <form method="POST" action="{{ route('eventos.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label text-secondary">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="form-control @error('titulo') is-invalid @enderror">
                    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label text-secondary">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror">
                        <option value="">Selecione…</option>
                        <option value="Show" @selected(old('categoria') == 'Show')>Show</option>
                        <option value="Teatro" @selected(old('categoria') == 'Teatro')>Teatro</option>
                        <option value="Palestra" @selected(old('categoria') == 'Palestra')>Palestra</option>
                        <option value="Esporte" @selected(old('categoria') == 'Esporte')>Esporte</option>
                    </select>
                    @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="duracao_minutos" class="form-label text-secondary">Duração (minutos)</label>
                    <input type="number" name="duracao_minutos" id="duracao_minutos" value="{{ old('duracao_minutos') }}" class="form-control @error('duracao_minutos') is-invalid @enderror">
                    @error('duracao_minutos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label text-secondary">Ingresso (R$)</label>
                    <input type="number" step="0.01" name="preco" id="preco" value="{{ old('preco') }}" class="form-control @error('preco') is-invalid @enderror">
                    @error('preco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="vagas" class="form-label text-secondary">Vagas</label>
                    <input type="number" name="vagas" id="vagas" value="{{ old('vagas') }}" class="form-control @error('vagas') is-invalid @enderror">
                    @error('vagas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
@endsection
