@extends('layouts.app')

@section('content')

    @php
    $param = Session()->get('url-back');
    @endphp

    <a href="{{ route('ad-set.edit', $param) }}" class="btn btn-secondary">Regresar</a>

    <br/>

    <h2>IMPORTANTE !!!</h2>
    <h3>Desactivar los bloqueadores de anuncios para ver la publicación</h3>

    <div id="post"></div>

@endsection
@section('personal_scripts')
    <script>
        var preview = '{{ $preview }}';
        preview = preview.replace(/&lt;/g, "<");
        preview = preview.replace(/&gt;/g, ">");
        preview = preview.replace(/&quot;/g, "\"");
        preview = preview.replace(/&amp;/g, "&");

        $("#post").html(preview);

    </script>
@endsection
