@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 col-12">
            <h1 class="display-5">Ошибка :(</h1>
            <hr class="my-4">
            <p class="lead">{{ $error }}</p>
            <a href="{{url()->previous()}}"><button class="btn btn-primary">Назад! </button></a>
        </div>
        <div class="col-md-5 col-12">
            <img src="img/Мем.png" alt="^.^" class="col-12">
        </div>
    </div>
@endsection