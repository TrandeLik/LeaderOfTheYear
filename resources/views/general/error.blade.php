@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7 col-12">
            <h1 class="display-5">Ошибка :(</h1>
            <hr class="my-4">
            <p class="lead">{{ $error }}</p>
            @if ($error == 'Ой, вам сюда нельзя!')
                @if ((Auth::user()->role == 'admin') or (Auth::user()->role == 'superadmin'))
                    <a href="{{url('/admin')}}"><button class="btn btn-primary">Назад! 1</button></a>
                @else
                    <a href="{{url('/user')}}"><button class="btn btn-primary">Назад!</button></a>
                @endif
            @else
                @if (Auth::user()->role != 'banned')
                    <a href="{{url()->previous()}}"><button class="btn btn-primary">jjjfjfj</button></a>
                @endif
            @endif
        </div>
        <div class="col-md-5 col-12">
            <img src="img/Мем.png" alt="^.^" class="col-12">
        </div>
    </div>
@endsection