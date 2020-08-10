<h2>Anuncios - Ads ({{ count($ads) }})</h2>

<a href="{{ route('ad.create') }}" class="btn btn-primary">Crear Anuncio</a>

<br />

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th colspan="2">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ads as $ad)
            <tr>
                <td>{{ $ad['id'] }}</td>
                <td>{{ $ad['name'] }}</td>
                <td>
                    <a href="{{ route('ad.show', $ad['id']) }}" class="btn btn-info">Ver</a>
                </td>
                <td>
                    @section('action'){{ route('ad.destroy', $ad['id']) }}
                    @overwrite
                    @include('layouts.partials.form-delete')
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
