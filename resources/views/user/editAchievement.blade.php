@extends('layouts.app')
<style>
    .btn-warning{
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
            <div class="card border-warning">
                <div class="card-header">Редактирование достижения<a href="/"><button class="btn btn-primary">Отмена</button></a></div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category" onchange="changeStage(); disableForStage(); changeType(); disableForType(); changeCategory(); disableForCategory();">
                            <option disabled>Категория</option>
                            @foreach ($categories as $category)
                                @if ($category->category==$achievement->category)
                                    <option selected>{{ $category->category }}</option>
                                @else
                                    <option>{{ $category->category }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="type" onchange = "changeStage(); disableForStage(); changeType(); disableForType();">
                            <option disabled>Тип достижения</option>
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
                        <select name="stage" onchange = "changeStage(); disableForStage();">
                            <option disabled>Этап</option>
                            @foreach ($stages as $stage)
                                @if ($stage->stage==$achievement->stage)
                                    <option selected>{{ $stage->stage }}</option>
                                @else
                                    <option>{{ $stage->stage }}</option>
                                @endif
                            @endforeach
                        </select> 
                        <select name="result">
                            <option disabled>Результат</option>
                            @foreach ($results as $result)
                                @if ($result->result==$achievement->result)
                                    <option selected>{{ $result->result }}</option>
                                @else
                                    <option>{{ $result->result }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($isUploadingConfirmationsPossible)
                            <label for="file">Новое подтверждение </label> <input id="file" type="file" name="file">
                            <input type="submit" value="Изменить" class="btn btn-warning col-4">
                        @else
                            <p>К сожалению, загрузка файлов временно невозможна</p>
                        @endif
                    </form>
                    @if($achievement->confirmation != '')
                        <a href="{{'/achievement/'.$achievement->id.'/download_confirmation'}}">Текущее подтверждение</a><br><br>
                    @else
                        <strong>На данный момент подтверждения нет</strong>
                    @endif
                </div>
            </div>
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
