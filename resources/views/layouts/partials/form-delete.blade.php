<form action="@yield('action')" method="POST">
    <input type="hidden" name="_method" value="DELETE" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <button type="submit" class="btn btn-danger">Eliminar</button>
</form>
