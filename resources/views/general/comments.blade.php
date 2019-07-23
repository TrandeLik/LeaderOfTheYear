@extends('layouts.app')
<style>
    .admin-comment{
        float:left;
        text-align: left;
    }

    .student-comment{
        float:right;
        text-align: right;
    }
</style>
@section('content')
    <div class="content">
        @foreach ($comments as $comment)
            @if ($comment->author=='admin')
                <div class="admin-comment">
                    <p>Admin</p>
                    <p>{{$comment->text}}</p>
                </div>
            @else
                <div class="student-comment">
                    <p>{{$comment->achievement->user->name}} <a href="{{url('/achievement/' . $comment->achievement_id)}}">к заявке</a></p>
                    <p>{{$comment->text}}</p>
                </div>
            @endif
        @endforeach
    </div>
@endsection