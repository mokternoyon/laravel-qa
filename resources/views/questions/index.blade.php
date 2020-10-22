@extends('layouts.app')
<style>
    .counters {
        margin-right: 30px;
        font-size: 10px;
        text-align: center;
    }

    .counters strong {
        display: block;
        font-size: 2em;
    }

    .vote,
    .answered {
        width: 60px;
        height: 60px;
    }

    .answered {
        border: 1px solid rgb(95, 187, 126);
        color: rgb(95, 187, 126);
    }

    .status {
        .answered {
            border: 1px solid rgb(95, 187, 126);
            color: rgb(95, 187, 126);
        }

        .answered-accepted {
            background-color: rgb(95, 187, 126);
            color: white;
        }

        .unanswered {
            border: none;
        }

    }

    .view {
        margin-top: 10px;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Questions</div>

                <div class="card-body">
                    @foreach ($questions as $question)
                    <div class="media">
                        <div class="d-flex flex-column counters">
                            <div class="vote">
                                <strong>{{ $question->votes }}</strong>
                                {{ Str::plural('vote', $question->votes ) }}
                            </div>
                            <div class="status answered">
                                <strong>{{ $question->answers }}</strong>
                                {{ Str::plural('answer', $question->answers ) }}
                            </div>
                            <div class="view">
                                {{ $question->views ." ". Str::plural('view', $question->views ) }}
                            </div>
                        </div>
                        <div class="media-body">
                            <h3 class="mt-0">
                                <a href="{{ $question->url}}">{{ $question->title }}</a>
                            </h3>
                            <p class="lead">
                                Asked by
                                <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                <small class="text-muted">{{ $question->created_date}}</small>
                            </p>
                            {{ Str::limit($question->body, 250)}}
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection