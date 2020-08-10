@extends('layouts.app')

@section("content")

    <a href="{{ url('campaign') }}" class="btn btn-primary">Promocionar Página</a>
    <br />
    <a href="{{ route('report.create') }}" class="btn btn-primary">Crear Informes de Anuncios</a>

@endsection
