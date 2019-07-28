@extends('layouts.app')
<style>
    .btn-primary{
        float:right;
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-primary">
                <div class="card-header">Изменение пароля<a href="/profile"><button class="btn btn-primary">Отмена</button></a></div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <p>Старый пароль: <input type="password" name="old" required></p>
                        <p>Новый пароль: <input type="password" name="new" required></p>
                        <p>Подтверждение пароля: <input type="password" name="confirm" required></p>
                        <input type="submit">
                    </form>
                    @if ($error !== '')
                        <strong>{{$error}}</strong>
                    @endif
                </div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection