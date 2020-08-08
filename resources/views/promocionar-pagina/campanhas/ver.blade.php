@extends('layouts.app')

@section('content')

    <a href="{{ url('campaign') }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Visualizar Campaña ({{ $campaign->id }})</h2>
    <br />

    <form action="{{ route('campaign.update', $campaign->id) }}" method="POST" class="container center">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name">Nombre de Campaña</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $campaign->name }}" required>
        </div>
        <div class="form-group">
            <label for="objective">Objetivos</label>
            <select class="form-control" id="objective" name="objective" required>
                @foreach ($objectives as $objective)
                    <option value="{{ $objective }}" @if ($campaign->objective == $objective)
                        selected
                @endif>{{ $objective }}</option>
                @endforeach
            </select>
        </div>
        <button type="sumit" class="btn btn-success">Editar</button>
        <a href="{{ url("campaign.delete", [ "id" => $campaign->id ]) }}"class="btn btn-danger">Eliminar</a>
    </form>

    @include('layouts.partials.message')

    <br />

    @include('promocionar-pagina.adsets.index')

@endsection