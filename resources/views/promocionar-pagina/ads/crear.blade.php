@extends('layouts.app')

@section('content')

    @php
        $param = Session()->get('url-back');
    @endphp

    <a href="{{ route('ad-set.edit', $param) }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Crear Anuncio de Anuncios para el Grupo</h2>
    <h3>{{ $ad_set->name }}</h3>
    <br />

    <form action="{{ route('ad.store') }}" method="POST" class="container center">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_ad_set" value="{{ $ad_set->id }}">
        <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label">Nombre del Anuncio</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="creative_id" class="col-sm-4 col-form-label">Contenido (Ad Creative)</label>
            <div class="col-sm-8">
                <select class="form-control" id="creative_id" name="creative_id" required>
                    <option disabled selected></option>
                    @foreach ($ad_creatives as $ad_creative)
                        <option value="{{ $ad_creative->id_fb }}">{{ $ad_creative->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="sumit" class="btn btn-success">Crear</button>
    </form>

    @include('layouts.partials.message')

@endsection
