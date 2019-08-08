@extends('layouts.app')
<style>
    .btn-danger{
        margin-left: 10px;
    }
</style>
@section('content')
    <div class="container">
        <div class="col-12">
        <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input accept=  "application/vnd.ms-excel,
                                                application/vnd.ms-office,
                                                application/vnd-xls,
                                                application/vnd.ms-excel,
                                                application/msexcel,
                                                application/x-msexcel,
                                                application/x-ms-excel,
                                                application/x-excel,
                                                application/excel,
                                                application/x-dos_ms_excel,
                                                application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                                                application/xls,
                                                application/x-xls" type="file" class="custom-file-input" id="file" name="file">
                                <label class="custom-file-label" for="file" data-browse="Обзор">Изменить список достижений</label>
                            </div>
                            <div class="input-group-prepend">
                                <input type="submit" class="btn btn-outline-secondary" value="Загузить">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
        <form id="1" method="POST" action="/achievement_types/delete_selected">@csrf</form>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Достижения<input type="submit" form="1" value="Удалить выбранные" class="btn btn-danger"><a href="/achievement_types/all/delete" class="btn btn-danger">Удалить все</a></th>
                <th scope="col">Баллы</th>
                <th scope="col"></th>
                <th scope="col"><a href='{{url('/achievement_type/add')}}'><button class="btn btn-success">Добавить</button></a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
                <tr>
                    <td scope="row"><input type="checkbox" form="1" name="{{$type->id}}"></td>
                    <td>{{
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
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection