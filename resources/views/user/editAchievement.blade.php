@extends('layouts.app')
<style>
    .btn-warning{
        margin-top: 20px;
    }
    
    .btn-primary{
        float:right;
    }

    .admin-comment{
        margin-right: auto;
        margin-left: 0;
        text-align: left;
    }

    .student-comment{
        margin-right: 0;
        margin-left: auto;
        text-align: right;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
            <div class="card border-warning">
                <div class="card-header">Редактирование<a href="/user"><button class="btn btn-primary">Отмена</button></a></div>
                <creating-achievement
                        :isUploadingConfirmationsPossible="{{json_encode($isUploadingConfirmationsPossible)}}"
                        :categories="{{json_encode($categories)}}"
                        :areCommentsWorking="{{json_encode($areCommentsWorking)}}"
                        :achievementTypes="{{json_encode($achievement_types)}}"
                        :achievement="{{json_encode($achievement)}}"
                        :action="'/achievement/{{$achievement->id}}/edit'"
                        :achievement_href="'/achievement/{{$achievement->id}}/download_confirmation'"
                >
                </creating-achievement>
            </div>
        </div>
    </div>
</div>
@endsection
