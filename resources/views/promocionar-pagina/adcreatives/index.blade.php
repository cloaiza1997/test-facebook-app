<h3>Contenido de Anuncio - Ad Creative ({{ count($ad_creatives) }})</h3>

<a href="{{ route('ad-creative.create') }}" class="btn btn-primary">Crear Contenido</a>

<br />

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Publicación</th>
            <th colspan="2">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ad_creatives as $ad_creative)
            <tr>
                <td>{{ $ad_creative['id'] }}</td>
                <td>{{ substr($ad_creative['name'], 0, 30) }} ...</td>
                <td>{{ explode('_', $ad_creative['object_story_id'])[1] }}</td>
                <td>
                    <a href="" class="btn btn-primary">Crear Anuncio</a>
                </td>
                <td>
                    @section('action')
                        {{ route('ad-creative.destroy', $ad_creative['id']) }}
                        @overwrite
                        @include('layouts.partials.form-delete')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
