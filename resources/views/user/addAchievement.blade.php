@extends('layouts.app')
<style>
    .btn-success{
        margin-top: 20px;
    }
    
    .btn-primary{
        float:right;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
            <div class="card border-success">
                <div class="card-header">Добавление<a href="/user"><button class="btn btn-primary">Отмена</button></a></div>
                <creating-achievement
                        :isUploadingConfirmationsPossible="{{json_encode($isUploadingConfirmationsPossible)}}"
                        :categories="{{json_encode($categories)}}"
                        :areCommentsWorking="{{json_encode($areCommentsWorking)}}"
                        :achievementTypes="{{json_encode($achievement_types)}}"
                        :action="'/achievement/add/new'">
                </creating-achievement>
            </div>
        </div>
    </div>
</div>
@endsection
