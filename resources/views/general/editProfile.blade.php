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
                <div class="card-body col-12">
                    <form method="POST" class="col-12">
                        @csrf
                        <p class="form-group row mb-1">
                            <label for="username" class="col-form-label col-md-1 px-0">ФИО:</label> 
                            <input type="text" class="form-control col-md-10 offset-md-1" value="{{$name}}" id="username" name="username" required>
                        </p>
                        <p class="form-group row mb-1">
                            <label for="email" class="col-form-label col-md-1 px-0">E-mail:</label> 
                            <input type="text" class="form-control col-md-10 offset-md-1" value="{{$email}}" id="email" name="email" required>
                        </p>
                        @if ($role=='student')
                            <p class="form-group row mb-1">
                                <label class="col-form-label col-md-1 px-0">Класс: </label>
                                <select name="formNumber" class="form-control col-md-5 offset-md-1" required>
                                    @foreach ($formNumbers as $formNumber)
                                        @if ($formNumber == $userFormNumber)
                                            <option selected>{{$formNumber}}</option>
                                        @else
                                            <option>{{$formNumber}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select name="formLetter" class="form-control col-md-5" required>
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
                        <input type="submit" class="btn btn-success col-12 col-md-4 offset-md-4" value='Сохранить'>
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