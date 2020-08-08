@if (session('message'))
    <br />
    <div class="message">
        {{ session('message') }}
    </div>
@endif
