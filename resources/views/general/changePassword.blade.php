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
                        <p>Старый пароль: <input type="password" name="old"></p>
                        <p>Новый пароль: <input type="password" name="new"></p>
                        <p>Подтверждение пароля: <input type="password" name="confirm"></p>
                        <input type="submit">
                    </form>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection