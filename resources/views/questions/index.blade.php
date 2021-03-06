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

    form.form-delete {
        display: inline;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2> All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    @include('layouts._massage')

                    @foreach ($questions as $question)
                    <div class="media">
                        <div class="d-flex flex-column counters">
                            <div class="vote">
                                <strong>{{ $question->votes_count }}</strong>
                                {{ Str::plural('vote', $question->votes_count ) }}
                            </div>
                            <div class="status answered">
                                <strong>{{ $question->answers_count }}</strong>
                                {{ Str::plural('answer', $question->answers_count ) }}
                            </div>
                            <div class="view">
                                {{ $question->views ." ". Str::plural('view', $question->views ) }}
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <h3 class="mt-0">
                                    <a href="{{ $question->url}}">{{ $question->title }}</a>
                                </h3>
                                <div class="ml-auto">
                                    @can('update', $question)
                                    <a href="{{ route('questions.edit', $question->id) }}"
                                        class="btn btn-sm btn-outline-info">Edit</a>
                                    @endcan

                                    @can('delete', $question)
                                    <form class="form-delete" method="POST"
                                        action="{{ route('questions.destroy', $question->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>

                                    </form>
                                    @endcan

                                </div>
                            </div>

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