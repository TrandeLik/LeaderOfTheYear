@extends('layouts.app')
<style>
    .btn-warning{
        margin-top: 20px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
            <div class="card border-warning">
                <div class="card-header">Редактирование достижения</div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category">
                            <option disabled selected>Категория</option>
                            @foreach ($categories as $category)
                                @if ($category==$achievement->category)
                                    <option selected>{{ $category }}</option>
                                @else
                                    <option>{{ $category }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="type">
                            <option disabled selected>Тип достижения</option>
                            @foreach ($types as $type)
                                @if ($type->type==$achievement->type)
                                    <option selected>{{ $type->type }}</option>
                                @else
                                    <option>{{ $type->type }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="text" name="name" placeholder="Название олимпиады" value="{{$achievement->name}}">
                        <input type="text" name="subject" placeholder="Предмет" value="{{$achievement->subject}}">
                        <select name="stage">
                            <option disabled selected>Этап</option>
                            @foreach ($stages as $stage)
                                @if ($stage==$achievement->stage)
                                    <option selected>{{ $stage }}</option>
                                @else
                                    <option>{{ $stage }}</option>
                                @endif
                            @endforeach
                        </select> 
                        <select name="result">
                            <option disabled selected>Результат</option>
                            @foreach ($results as $result)
                                @if ($result==$achievement->result)
                                    <option selected>{{ $result }}</option>
                                @else
                                    <option>{{ $result }}</option>
                                @endif
                            @endforeach
                        </select>
                        {{--<input type="file" name="file" placeholder="Подтверждение">--}}
                        <input type="submit" value="Изменить" class="btn btn-warning col-4">
                    </form>
                    <a href="{{'/achievement/'.$achievement->id.'/download_confirmation'}}">Подтверждение</a><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
