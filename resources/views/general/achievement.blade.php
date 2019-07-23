@extends('layouts.app')
<style>
    .admin-comment{
        margin-right: auto;
        margin-left: 0;
        text-align: left;
    }

    .student-comment{
        margin-right: 0;
        margin-left: auto;
        text-align: right;
    }
</style>
@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
        Посмотреть комментарии
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Комментарии</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="content">
                    @foreach ($comments as $comment)
                        @if ($comment->author=='admin')
                            <div class="admin-comment">
                                <p>Admin</p>
                                <p>{{$comment->text}}</p>
                            </div>
                        @else
                            <div class="student-comment">
                                <p>{{$comment->achievement->user->name}}</p>
                                <p>{{$comment->text}}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
            </div>
        </div>
    </div>
    
@endsection