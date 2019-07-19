@extends('layouts.app')

@section('content')
    <div class="row">
        <achievement-table :achievements="{{json_encode($achievements)}}"></achievement-table>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
@endsection