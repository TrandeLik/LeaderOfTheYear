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
                <div class="card-header">Редактирование достижения<a href="/user"><button class="btn btn-primary">Отмена</button></a></div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category" onchange="changeStage(); disableForStage(); changeType(); disableForType(); changeCategory(); disableForCategory();" required>
                            <option disabled>Категория</option>
                            @foreach ($categories as $category)
                                @if ($category->category==$achievement->category)
                                    <option selected>{{ $category->category }}</option>
                                @else
                                    <option>{{ $category->category }}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="type" onchange = "changeStage(); disableForStage(); changeType(); disableForType();" required>
                            <option disabled>Тип достижения</option>
                            @foreach ($types as $type)
                                @if ($type->type==$achievement->type)
                                    <option selected>{{ $type->type }}</option>
                                @else
                                    <option>{{ $type->type }}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="text" name="name" placeholder="Название олимпиады" value="{{$achievement->name}}" required>
                        <input type="text" name="subject" placeholder="Предмет" value="{{$achievement->subject}}" required>
                        <select name="stage" onchange = "changeStage(); disableForStage();" required>
                            <option disabled>Этап</option>
                            @foreach ($stages as $stage)
                                @if ($stage->stage==$achievement->stage)
                                    <option selected>{{ $stage->stage }}</option>
                                @else
                                    <option>{{ $stage->stage }}</option>
                                @endif
                            @endforeach
                        </select> 
                        <select name="result" required>
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
                            <label for="file">Новое подтверждение  (.png, .jpg, .jpeg, .pdf)</label>
                            <input accept="application/pdf,
                                image/jpeg,
                                image/pjpeg,
                                image/x-jps,
                                image/png"
                            id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                        @else
                            <p>К сожалению, загрузка файлов временно невозможна</p>
                        @endif
                        <input type="submit" value="Изменить" class="btn btn-warning col-4">
                        @if ($areCommentsWorking)
                            <div class="accordion" id="accordionExample">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Что-то пошло не так? Оставьте комментарий</button>
                                <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <textarea name="comment" placeholder = "Комментарий"></textarea>
                                </div>
                            </div>
                        @else
                            <p>К сожалению, возможность добавлять комментарии отключена</p>
                        @endif
                    </form>
                    @if($achievement->confirmation != '')
                        <a href="{{'/achievement/'.$achievement->id.'/download_confirmation'}}">Текущее подтверждение</a><br><br>
                    @else
                        <strong>На данный момент подтверждения нет</strong>
                    @endif
                </div>
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
