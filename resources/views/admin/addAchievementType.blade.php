@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>События</h2>
                <div class='card'>
                    <div class='card-body'>
                    <form method="post">
                      @csrf
                      <input type='text' name="type" placeholder="Тип события" class="form-control"><br>
                      <select name="stage" class="form-control">
                            <option disabled selected>Этап</option>
                            @foreach ($stages as $stage)
                                <option>{{ $stage }}</option>
                            @endforeach
                      </select><br>
                      <select name="result" class="form-control">
                            <option disabled selected>Результат</option>
                            @foreach ($results as $result)
                                <option>{{ $result }}</option>
                            @endforeach
                      </select><br>
                      <input type="number" name="score" placeholder="Кол-во баллов" class="form-control"><br>
                      <input type="submit" value="Отправить" class="btn btn-primary">
                    </form>
                    </div>
              </div>
        </div>
    </div>
  </div>
@endsection
