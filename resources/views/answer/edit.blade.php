@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Editing answer for question: <strong>{{ $question->title}}</strong> </h2>
                    </div>
                    <hr>
                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : ''}}" name="body"
                                rows="7">{{ old('body', $answer->body)}} </textarea>
                            @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection