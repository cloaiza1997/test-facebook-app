@extends('layouts.app')

@section('content')

    <a href="{{ url('/') }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Crear Informe</h2>
    <br />

    <form action="{{ route('report.store') }}" method="POST" class="container center">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="since">Desde</label>
            <input type="date" class="form-control" id="since" name="since" required>
        </div>
        <div class="form-group">
            <label for="until">Hasta</label>
            <input type="date" class="form-control" id="until" name="until" required>
        </div>
        <div class="form-group">
            <label for="level">Nivel</label>
            <select class="form-control" id="level" name="level" required>
                <option disabled selected></option>
                @foreach ($levels as $level)
                    <option value="{{ $level['level'] }}">{{ $level['name'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="sumit" class="btn btn-success">Generar</button>
    </form>

    @include('layouts.partials.message')

@endsection
