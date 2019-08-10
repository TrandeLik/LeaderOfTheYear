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
                        <p class="form-group row mb-1">
                            <label class="col-form-label col-md-3 px-0">Старый пароль:</label> 
                            <input type="password" class="form-control col-md-9" name="old" required>
                        </p>
                        <p class="form-group row mb-1">
                            <label class="col-form-label col-md-3 px-0">Новый пароль:</label> 
                            <input type="password" class="form-control col-md-9" name="new" required>
                        </p>
                        <p class="form-group row mb-1">
                            <label class="col-form-label col-md-3 px-0">Подтверждение пароля:</label>
                            <input type="password" class="form-control col-md-9" name="confirm" required>
                        </p>
                        <input type="submit" class="btn btn-success col-12 col-md-4 offset-md-4" value="Сохранить">
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