@extends('layouts.app')
<style>
    .btn-success{
        margin-top: 20px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
            <div class="card border-success">
                <div class="card-header">Редактирование достижения</div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category">
                            <option disabled selected>Категория</option>
                            @foreach ($categories as $category)
                                <option>{{ $category }}</option>
                            @endforeach
                        </select>
                        <select name="type">
                            <option disabled selected>Тип достижения</option>
                            @foreach ($types as $type)
                                <option>{{ $type->type }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="name" placeholder="Название олимпиады">
                        <input type="text" name="subject" placeholder="Предмет">
                        <select name="stage">
                            <option disabled selected>Этап</option>
                            @foreach ($stages as $stage)
                                <option>{{ $stage }}</option>
                            @endforeach
                        </select>
                        <select name="result">
                            <option disabled selected>Результат</option>
                            @foreach ($results as $result)
                                <option>{{ $result }}</option>
                            @endforeach
                        </select>
                        <label for="file" class="btn">Подтверждение</label>
                        <input id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                        <input type="submit" value="Добавить" class="btn btn-success col-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection