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
                        <p>ФИО: <input type="text" value="{{$name}}" name="name"></p>
                        <p>E-mail: <input type="text" value="{{$email}}" name="email"></p>
                        <p>
                            Класс: 
                            <select name="formNumber">
                                @foreach ($formNumbers as $formNumber)
                                    @if ($formNumber == $userFormNumber)
                                        <option selected>{{$formNumber}}</option>
                                    @else
                                        <option>{{$formNumber}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <select name="formLetter">
                                @foreach ($formLetters as $formLetter)
                                    @if ($formLetter == $userFormLetter)
                                        <option selected>{{$formLetter}}</option>
                                    @else
                                        <option>{{$formLetter}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </p>
                        <input type="submit">
                    </form>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection