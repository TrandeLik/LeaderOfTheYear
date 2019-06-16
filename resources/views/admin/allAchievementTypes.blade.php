@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Достижения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
                <tr>
                    <td scope="row">{{
                        $type->category.', '.$type->type.', '.$type->stage.', '.$type->result
                    }}</td>
                    <td><a href={{url('/achievement_type/'.$type->id.'/edit')}}> <button class="btn btn-warning">Изменить </button></a></td>
                    <td><a href={{url('/achievement_type/'.$type->id.'/delete')}}><button class="btn btn-danger"> Удалить </button></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{url('/add_achievement_type')}}">Добавить событие</a>
    </div>
    <a href="{{url('/')}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection