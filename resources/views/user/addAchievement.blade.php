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
            <div class="card border-success" id="app">
                <div class="card-header">Добавление достижения<a href="/user"><button class="btn btn-primary">Отмена</button></a></div>
                <creating-achievement
                        :isUploadingConfirmationsPossible="{{json_encode($isUploadingConfirmationsPossible)}}"
                        :categories="{{json_encode($categories)}}"
                        :areCommentsWorking="{{json_encode($areCommentsWorking)}}"
                        :achievementTypes="{{json_encode($achievement_types)}}">
                </creating-achievement>
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
<script>
    let achievements = [];
    @foreach ($achievement_types as $achievement_type)
        achievements.push({category: "{{$achievement_type->category}}", type: "{{$achievement_type->type}}", stage: "{{$achievement_type->stage}}", result: "{{$achievement_type->result}}"});
    @endforeach
</script>
<script src="/js/achievementSelection.js"></script>
@endsection
