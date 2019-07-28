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
                <div class="card-header">Личные данные<a href="/profile"><button class="btn btn-primary">Отмена</button></a></div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <p>ФИО: <input type="text" value="{{$name}}" name="username" required></p>
                        <p>E-mail: <input type="text" value="{{$email}}" name="email" required></p>
                        @if ($role=='student')
                            <p>
                                Класс: 
                                <select name="formNumber" required>
                                    @foreach ($formNumbers as $formNumber)
                                        @if ($formNumber == $userFormNumber)
                                            <option selected>{{$formNumber}}</option>
                                        @else
                                            <option>{{$formNumber}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select name="formLetter" required>
                                    @foreach ($formLetters as $formLetter)
                                        @if ($formLetter == $userFormLetter)
                                            <option selected>{{$formLetter}}</option>
                                        @else
                                            <option>{{$formLetter}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </p>
                        @endif
                        <input type="submit">
                    </form>
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