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
                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#uploadListModal">
                                    Загрузить
                                </button>
                                <div class="modal fade" id="uploadListModal" tabindex="-1" role="dialog" aria-labelledby="uploadListModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="uploadListModalLabel">Подтвердите действие</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Вы действительно хотите загрузить новый список типов достижений? Все старые типы будут автоматически удалены
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                <input type="submit" class="btn btn-outline-secondary" value="Загузить">
                                            </div>
                                        </div>
                                    </div>
                                </div>  
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
                <th scope="col">
                    Достижения
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteSelectedModal">
                        Удалить выбранные
                    </button>
                    <div class="modal fade" id="deleteSelectedModal" tabindex="-1" role="dialog" aria-labelledby="deleteSelectedModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSelectedModalLabel">Подтвердите действие</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="font-weight:normal;">
                                    Вы действительно хотите удалить выбранные типы достижений?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                    <input type="submit" form="1" value="Удалить выбранные" class="btn btn-danger">
                                </div>
                            </div>
                        </div>
                    </div>  
                    
                    <confirm-action style="font-weight:normal;"
                            :button-class="'btn btn-danger'"
                            :button-text="'Удалить все'"
                            :button-action="'/achievement_types/all/delete'"
                            :modal-text="'Вы уверены, что хотите удалить все типы достижений?'"
                            :id="'deleteAll'"
                    ></confirm-action>
                </th>
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
                    <td>
                        <confirm-action
                                :button-class="'btn btn-danger'"
                                :button-text="'Удалить'"
                                :button-action="'/achievement_type/{{$type->id}}/delete'"
                                :modal-text="'Вы уверены, что хотите удалить тип достижения?'"
                                :id="'delete{{$type->id}}'"
                        ></confirm-action>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection