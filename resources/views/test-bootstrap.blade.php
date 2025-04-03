@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Teste Bootstrap 5</h1>

    <button class="btn btn-primary">Botão Primary</button>
    <button class="btn btn-success">Botão Success</button>

    <div class="alert alert-warning mt-3">
        Este é um alerta do Bootstrap!
    </div>

    <div class="card mt-3" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Card Title</h5>
            <p class="card-text">Some quick example text to build on the card title.</p>
            <a href="#" class="btn btn-danger">Go somewhere</a>
        </div>
    </div>
</div>
@endsection
