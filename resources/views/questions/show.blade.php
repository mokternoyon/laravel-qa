@extends('layouts.app')
<style>
    .vote-controls {
        min-width: 60px;
        margin-right: 30px;
        text-align: center;
        color: gray;
    }

    .vote-controls span,
    a {
        display: block;
        color: gray;
    }

    .vote-controls span.vote-count {
        font-size: 25px;
    }

    .vote-controls span.favorite-count {
        font-size: 15px;
    }

    .vote-controls a {
        cursor: pointer;
        color: gray;
    }

    .vote-controls .vote-down {
        color: lightgray;
    }

    .vote-controls .favorite {
        color: rgb(231, 231, 24);
    }

    .vote-controls .vote-accept {
        color: rgb(17, 30, 212);
    }

    .vote-controls .vote-accepted {
        color: rgb(25, 151, 25);
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>{{ $question->title}}</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to All
                                    Questions</a>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="media">

                        <div class="d-flex flex-column vote-controls">
                            <a data-toggle="tooltip" title="This question is useful" class="vote-up">
                                <i class="fa fa-caret-up fa-3x"></i>
                            </a>
                            <span class="vote-count">1230</span>
                            <a data-toggle="tooltip" title="This question is not useful" class="vote-down off">
                                <i class="fa fa-caret-down fa-3x"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="bottom"
                                title="Click to mark as favorite (Click again to undo" class="favorite">
                                <i class="fa fa-star fa-2x"></i>
                            </a>
                            <span class="favorite-count">1230</span>
                        </div>

                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="float-right">
                                <span class="text-muted">Question Created {{ $question->created_date}}</span>

                                <div class="media mt-1">
                                    <a href="{{ $question->user->url}}" class="pr-2">
                                        <img src="{{ $question->user->avatar}}" alt="">
                                    </a>
                                    <div class="media-body mt-1">
                                        <a href="{{ $question->user->url}}">{{$question->user->name}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $question->answers_count . " " . Str::plural('Answer', $question->answers_count)}}</h2>
                    </div>
                    <hr>
                    @include('layouts._massage')
                    @foreach ($question->answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a data-toggle="tooltip" data-placement="top" title="This answer is useful" class="vote-up">
                                <i class="fa fa-caret-up fa-3x"></i>
                            </a>
                            <span class="vote-count">1230</span>
                            <a data-toggle="tooltip" data-placement="bottom" title="This answer is not useful"
                                class="vote-down off">
                                <i class="fa fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept', $answer)

                            <a data-toggle="tooltip" data-placement="bottom" title="Mark this answer as best answer"
                                class="{{ $answer->status  }}"
                                onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                <i class="fa fa-check fa-2x"></i>
                            </a>
                            <form id="accept-answer-{{$answer->id}}" action="{{route('answers.accept', $answer->id)}}"
                                method="POST" style="display:none;">
                                @csrf
                            </form>
                            @else
                            @if ($answer->is_best)
                            <a data-toggle="tooltip" data-placement="bottom"
                                title="The question owner accepted this answer as best answer"
                                class="vote-accepted {{ $answer->status  }}">
                                <i class="fa fa-check fa-2x"></i>
                            </a>
                            @endif
                            @endcan
                        </div>

                        <div class="media-body">

                            {!! $answer->body_html !!}

                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update', $answer)
                                        <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
                                            class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan

                                        @can('delete', $answer)
                                        <form class="form-delete" method="POST"
                                            action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>

                                <div class="col-4"></div>

                                <div class="col-4">
                                    <span class="text-muted">Answerd {{ $answer->created_date}}</span>

                                    <div class="media mt-1">
                                        <a href="{{ $answer->user->url}}" class="pr-2">
                                            <img src="{{ $answer->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $answer->user->url}}">{{$answer->user->name}}</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your Answer</h2>
                    </div>
                    <hr>
                    <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : ''}}" name="body"
                                rows="7"></textarea>
                            @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection