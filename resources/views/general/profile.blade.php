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
                <div class="card-header">Личные данные<a href="/profile/edit"><button class="btn btn-primary">Изменить</button></a></div>
                <div class="card-body">
                    <p>ФИО: {{$user->name}}</p>
                    <p>E-mail: {{$user->email}}</p>
                    <p>Класс: {{$user->form}}</p>
                    <a href="/profile/password_change"><button class="btn btn-warning">Изменить пароль</button></a>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection