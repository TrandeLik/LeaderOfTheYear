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
                <div class="card-header">Добавление достижения<a href="/"><button class="btn btn-primary">Отмена</button></a></div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category" onchange="changeStage(); disableForStage(); changeType(); disableForType(); changeCategory(); disableForCategory();">
                            <option selected disabled>Категория</option>
                            @foreach ($categories as $category)
                                <option>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <select name="type" onchange = "changeStage(); disableForStage(); changeType(); disableForType();" disabled>
                            <option selected disabled>Тип</option>
                        </select>
                        <input type="text" name="name" placeholder="Название олимпиады">
                        <input type="text" name="subject" placeholder="Предмет">
                        <select name="stage" onchange = "changeStage(); disableForStage();" disabled>
                            <option selected disabled>Этап</option>
                        </select>
                        <select name="result" disabled>
                            <option selected disabled>Результат</option>
                        </select>
                        <label for="file" class="btn">Подтверждение</label>
                        <input id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                        <input type="submit" value="Добавить" class="btn btn-success col-4">
                        <div class="accordion" id="accordionExample">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Что-то пошло не так? Оставьте комментарий</button>
                            <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <textarea name="comment" placeholder = "Комментарий"></textarea>
                            </div>
                        </div>
                    </form>
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
