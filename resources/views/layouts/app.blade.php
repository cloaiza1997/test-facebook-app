<!DOCTYPE html>
<html lang="es">

@include("layouts.partials.header")

<body>

    <header class="content">
        <h1>Facebook API</h1>
    </header>

    <br/>

    <div class="content">
        @yield("content")
    </div>

    <br/>

    <footer class="content">
        Prueba de Desarrollo - Waco Services
        <br/>
        Desarrollado por Cristian Loaiza
        <br/>
        &copy; 2020
    </footer>

    @include("layouts.partials.scripts")

</body>
</html>
