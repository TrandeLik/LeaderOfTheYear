@extends('layouts.app')
<style>
    .btn-success{
        margin-top:10px;
    }
</style>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-success">
                    <div class="card-header">Настройки</div>
                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            @foreach ($settings as $setting)
                                <div class="form-group row">
                                    <label for="{{$setting->id}}" class="col-md-4 col-form-label text-md-right">{{$setting->name}}</label>
                                    @if ($setting->type=='on/off')
                                        <input type="checkbox" name="{{$setting->id}}" checked>
                                        @if ($setting->value=='on')
                                            <input type="checkbox" name="{{$setting->id}}" checked>
                                        @else
                                            <input type="checkbox" name="{{$setting->id}}">
                                        @endif
                                    @elseif ($setting->type=='globalVariable')
                                        @if ($setting->name != 'Главная категория')
                                            <input type="text" name="{{$setting->id}}" value="{{$setting->value}}">
                                        @else
                                            <select name="{{$setting->id}}">
                                                @foreach($categories as $category)
                                                    @if ($setting->value == $category -> category)
                                                        <option selected>{{$category -> category}}</option>
                                                    @else
                                                        <option>{{$category -> category}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                    @elseif ($setting->type=='rulesSettings')
                                        <input name="{{$setting->id}}" onchange="document.getElementById('{{$setting->id}}').innerHTML = this.value;" type="range" value="{{$setting->value}}" step="5"/>
                                        <span id = "{{$setting->id}}" >{{$setting->value}}</span>
                                    @endif
                                </div>
                            @endforeach
                            <input type="submit" value="Сохранить" class="btn btn-success col-md-4 offset-md-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary">Назад</button> </a>
   
@endsection