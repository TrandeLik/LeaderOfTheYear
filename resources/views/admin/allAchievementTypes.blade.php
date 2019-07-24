@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <label for="file" class="btn" style="padding: 0; margin: 0;">Добавить новый список</label>
                <input id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                <input type="submit" value="Добавить">
            </form>
        </div>
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Достижения</th>
                <th scope="col">Баллы</th>
                <th scope="col"></th>
                <th scope="col"><a href='{{url('/achievement_type/add')}}'><button class="btn btn-success">Добавить</button></a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
                <tr>
                    <td scope="row">{{
                        $type->category.', '.$type->type.', '.$type->stage.', '.$type->result
                    }}</td>
                    <td>{{$type->score}}</td>
                    <td><a href={{url('/achievement_type/'.$type->id.'/edit')}}> <button class="btn btn-warning">Изменить</button></a></td>
                    <td><a href={{url('/achievement_type/'.$type->id.'/delete')}}><button class="btn btn-danger">Удалить</button></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <a href="{{url('/')}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection