@extends('layouts.app')

@section('content')

    <a href="{{ route('campaign.edit', $campaign->id) }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Grupo de Anuncios ({{ $ad_set->id }})</h2>
    <h3>Campaña {{ $campaign->name }}</h3>
    <br />

    <form id="frm-update-ad-set" action="{{ route('ad-set.update', $ad_set->id) }}" method="POST" class="container center">
        <input type="hidden" name="_method" value="PUT" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_campaign" value="{{ $campaign->id }}">
        <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label">Nombre del Grupo</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="name" name="name" value="{{ $ad_set->name }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_time" class="col-sm-4 col-form-label">Inicio</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="start_time" name="start_time" value="{{ $ad_set->start_time }}"
                    min="{{ Date('Y-m-d') }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_time" class="col-sm-4 col-form-label">Fin</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="end_time" name="end_time" value="{{ $ad_set->end_time }}"
                    min="{{ Date('Y-m-d') }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="billing_event" class="col-sm-4 col-form-label">Evento de Facturación</label>
            <div class="col-sm-8">
                <select class="form-control" id="billing_event" name="billing_event" required>
                    <option disabled selected></option>
                    @foreach ($billing_events as $event)
                        <option value="{{ $event }}" @if ($ad_set->billing_event == $event)
                            selected
                    @endif>{{ $event }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="optimization_goal" class="col-sm-4 col-form-label">Objetivo de Optimización</label>
            <div class="col-sm-8">
                <select class="form-control" id="optimization_goal" name="optimization_goal" required>
                    <option disabled selected></option>
                    @foreach ($optimization_goals as $goal)
                        <option value="{{ $goal }}" @if ($ad_set->optimization_goal == $goal)
                            selected
                    @endif>{{ $goal }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="daily_budget" class="col-sm-4 col-form-label">Presupuesto Diario</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" id="daily_budget" name="daily_budget"
                    value="{{ $ad_set->daily_budget }}" required>
            </div>
        </div>
    </form>

    <div class="flx">
        <button type="sumit" class="btn btn-success" form="frm-update-ad-set">Editar</button>
        &nbsp;
    @section('action', route('ad-set.destroy', "{$campaign->id}-{$ad_set->id}"))
        @include('layouts.partials.form-delete')
    </div>

    @include('layouts.partials.message')
    <hr />
    @include('promocionar-pagina.adcreatives.index')

@endsection
