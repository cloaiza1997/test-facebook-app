@extends('layouts.app')

@section('content')

    @php
        $param = Session()->get('url-back');
    @endphp

    <a href="{{ route('ad-set.edit', $param) }}" class="btn btn-secondary">Regresar</a>

    <br />
    <h2>Crear Contenido</h2>
    <br />

    <form action="{{ route('ad-creative.store') }}" method="POST" class="container center">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label">Nombre</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="name" name="name" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="title" class="col-sm-4 col-form-label">Título</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="image_url" class="col-sm-4 col-form-label">URL de Imagen</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>
            <img class="col-sm-2" id="img" src="" alt="image" style="display: none" />
        </div>
        <div class="form-group row">
            <label for="body" class="col-sm-4 col-form-label">Cuerpo</label>
            <div class="col-sm-8">
                <textarea type="text" class="form-control" id="body" name="body" required></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="id_post" class="col-sm-4 col-form-label">Id de la Publicación</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" id="id_post" name="id_post" required>
            </div>
        </div>

        <button type="sumit" class="btn btn-success">Crear</button>
    </form>

    @include('layouts.partials.message')

@endsection
@section('personal_scripts')
    <script>
        $("#image_url").on('change', function(element) {

            var url = $(this).val().trim();

            if (url) {
                $("#img").attr("src", url);
                $("#img").show();
            } else {
                $("#img").hide();
            }

        });

    </script>
@endsection
