@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST">
        @csrf
        <select name="type">
            <option selected disabled>Тип достижения</option>
            @foreach ($types as $type)
                <option>{{ $type->type }}</option>
            @endforeach
        </select>
        <input type="text" name="name" placeholder="Название олимпиады">
        <input type="text" name="subject" placeholder="Предмет">
        <select name="stage">
            <option disabled selected>Этап</option>
            <option value="школьный">Школьный</option>
            <option value="окружной">Окружной</option>
            <option value="городской">Городской</option>
            <option value="всероссийский">Всероссийский</option>
        </select>
        <select name="result">
            <option disabled selected>Результат</option>
            <option value="призер">Призёр</option>
            <option value="победитель">Победитель</option>
        </select>
        <input type="text" name="confirmation" placeholder="Ссылка на подтверждение">
        <input type="submit">
    </form>
</div>
@endsection