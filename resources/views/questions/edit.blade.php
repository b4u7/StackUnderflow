@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="buttons has-text-weight-bold is-right">
            <a class="button is-primary is-uppercase" href="{{ route('questions.show', $question->id) }}">
                Go back
            </a>
        </div>
        <div class="box">
            <form action="{{ route('questions.update', [$question]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="field">
                    <label class="label">
                        Title
                    </label>
                    <div class="control">
                        <input class="input" type="text" name="title" placeholder="Title" value="{{ $question->title }}">
                    </div>
                </div>
                <div class="field">
                    <label class="label">
                        Body
                    </label>
                    <div class="control">
                        <textarea id="emde" class="textarea" name="body"></textarea>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary is-uppercase">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var easyMDE = new EasyMDE({
            element: document.getElementById('emde'),
            initialValue: @json($question->body),
            placeholder: 'Type here...',
        });
    </script>
@endpush
