@extends('layouts.app')

@section('content')

    <a href="{{ url('campaign') }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Crear Ad Set de Campaña</h2>
    <h3></h3>
    <br />

    <form action="{{ route('campaign.store') }}" method="POST" class="container center">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="name">Nombre de Campaña</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="objective">Objetivos</label>
            <select class="form-control" id="objective" name="objective" required>
                <option disabled selected></option>
                @foreach ($objectives as $objective)
                    <option value="{{ $objective }}">{{ $objective }}</option>
                @endforeach
            </select>
        </div>
        <button type="sumit" class="btn btn-success">Crear</button>
    </form>

    @include('layouts.partials.message')

@endsection
