@extends('layouts.app')

@section('content')

    <a href="{{ url('/') }}" class="btn btn-secondary">Regresar</a>
    <br />
    <h2>Promocionar Página</h2>
    <br />
    <h3>Campañas ({{ count($campaigns) }})</h3>
    <br />
    <a href="{{ route('campaign.create') }}" class="btn btn-primary">Crear Campaña</a>

    @include('layouts.partials.message')

    <br />
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Objetivo</th>
                <th>Fecha</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign['id'] }}</td>
                    <td>{{ $campaign['name'] }}</td>
                    <td>{{ $campaign['objective'] }}</td>
                    <td>{{ $campaign['created_at'] }}</td>
                    <td>
                        <a href="{{ route('campaign.edit', $campaign['id']) }}" class="btn btn-primary">Ver</a>
                    </td>
                    <td>
                        @section('action')
                            {{ route('campaign.destroy', $campaign['id']) }}
                            @overwrite
                            @include('layouts.partials.form-delete')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endsection
