@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>События</h1>
                <div class='card'>
                    <div class='card-body'>
                        <form method="post">
                            @csrf
                            <div name="categoryDiv">
                                <select name="category" onchange="writeTypes();" required>
                                    <option disabled selected>Категория</option>
                                    @foreach ($categories as $category)
                                        @if ($category->category == $thisType->category)
                                            <option selected>{{ $category->category }}</option>
                                        @else
                                            <option>{{ $category->category }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="button" name="category" onclick="changeInput('category');" value="Добавить" required>
                            </div>
                            <div name="typeDiv">
                                <select name="type" required>
                                    <option disabled>Тип события</option>
                                </select>
                                <input type="button" name="type" onclick="changeInput('type');" value="Добавить" required>
                            </div><br>
                            <div name="stageDiv">
                                <select name="stage" class="form-control" required>
                                    <option disabled selected>Этап</option>
                                    @foreach ($stages as $stage)
                                        @if ($stage->stage  == $thisType->stage)
                                            <option selected>{{ $stage->stage }}</option>
                                        @else
                                            <option>{{ $stage->stage }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="button" name="stage" onclick="changeInput('stage');" value="Добавить" required>
                            </div><br>
                            <div name="resultDiv">
                                <select name="result" class="form-control" required>
                                    <option disabled selected>Результат</option>
                                    @foreach ($results as $result)
                                        @if ($result->result  == $thisType->result)
                                            <option selected>{{ $result->result }}</option>
                                        @else
                                            <option>{{ $result->result }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="button" name="result" onclick="changeInput('result');" value="Изменить" required>
                            </div><br>
                            <input type="number" name="score" placeholder="Кол-во баллов" class="form-control" value="{{$thisType->score}}" required><br>
                            <input type="submit" value="Отправить" class="btn btn-primary" required>
                        </form>
                        <div name="unused" style="display:none;">
                            <input type='text' name="category" placeholder="Категория" class="form-control">
                            <input type='text' name="type" placeholder="Тип события" class="form-control">
                            <input type='text' name="stage" placeholder="Этап" class="form-control">
                            <input type='text' name="result" placeholder="Результат" class="form-control">
                        </div>
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
    <a href="{{url('/admin/allAchievementTypes')}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
    <script src="/js/achievementSelection.js"></script>
    <script>
        let achievements = [];
        @foreach ($achievementTypes as $achievementType)
            achievements.push({category: "{{$achievementType->category}}", type: "{{$achievementType->type}}", stage: "{{$achievementType->stage}}", result: "{{$achievementType->result}}"});
        @endforeach
        changeCategory();
        let typeSelect = document.getElementsByName('type')[0];
        for (let i = 0; i < typeSelect.length; i++){
            if (typeSelect.options[i].value == {{$thisType->type}}){
                typeSelect.options[i].selected = true;
            }
        }
    </script>
    <script>
        function writeTypes(){
            changeCategory();
            document.getElementsByName('type')[0].disabled = false;
        }

        function changeInput(name){
            let elements = document.getElementsByName(name);
            let parent = document.getElementsByName(name+'Div')[0];
            let el = parent.replaceChild(elements[2],elements[0]);
            document.getElementsByName('unused')[0].appendChild(el);
            if (elements[1].value == 'Добавить'){
                elements[1].value = 'Выбрать';
            } else {
                elements[1].value = 'Добавить';
            }
        }
    </script>
@endsection