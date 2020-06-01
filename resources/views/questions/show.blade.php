@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content box">
            <div class="question">
                <div class="question__header">
                    <h1>
                        {{ $question->title }}
                    </h1>
                </div>
                <div class="question__body">
                    <div class="columns">
                        <div class="column is-1">
                            <p>
                                {{ $question->votes_sum }}
                            </p>
                            <form action="{{ route('questions.upvote', $question) }}" method="POST">
                                @csrf
                                <button
                                    class="button vote-button is-icon is-rounded @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) is-active @endif"
                                    type="submit"
                                >
                                    <i class="fas fa-arrow-circle-up"></i>
                                </button>
                            </form>
                            <form action="{{ route('questions.downvote', $question) }}" method="POST">
                                @csrf
                                <button
                                    class="button vote-button is-icon is-rounded @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '-1')->count() === 1) is-active @endif"
                                    type="submit"
                                >
                                    <i class="fas fa-arrow-circle-down"></i>
                                </button>
                            </form>
                        </div>
                        <div class="column">
                            <p>
                                @parsedown($question->body)
                            </p>
                        </div>
                    </div>
                </div>
                <div class="question__footer has-text-right">
                    <!-- TODO: Avatars -->
                    <img src="{{ Avatar::create($question->user->name)->toBase64() }}"
                         height="54px"
                         width="54px"
                         alt=""
                    >
                    @can('update', $question)
                        <a class="button is-icon is-rounded" href="{{ route('questions.edit', $question->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    @endcan
                </div>
            </div>
            <h1>
                {{ count($answers) }} Answer(s)
            </h1>
            {{-- TODO: Edit the design here --}}
            <div class="answers">
                @foreach ($answers as $answer)
                    <div class="question__header">
                        <h1>
                            {{ $answer->title }}
                        </h1>
                    </div>
                    <div class="question__body">
                        <div class="columns">
                            <div class="column is-1">
                                <p>
                                    {{ $answer->votes_sum }}
                                </p>
                                <form action="{{ route('answers.upvote', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="button vote-button is-icon is-rounded @if($answer->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) is-active @endif"
                                        type="submit"
                                    >
                                        <i class="fas fa-arrow-circle-up"></i>
                                    </button>
                                </form>
                                <form action="{{ route('answers.downvote', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="button vote-button is-icon is-rounded @if($answer->votes->where('user_id', '=', Auth::id())->where('vote', '=', '-1')->count() === 1) is-active @endif"
                                        type="submit"
                                    >
                                        <i class="fas fa-arrow-circle-down"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="column">
                                <p>
                                    @parsedown($question->body)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="question__footer has-text-right">
                        <img src="{{ Avatar::create($answer->user->name)->toBase64() }}"
                             height="54px"
                             width="54px"
                             alt=""
                        >
                        @can('update', $answer)
                            <a class="button is-icon is-rounded"
                               href="{{ route('answers.edit', [$question, $answer]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan
                        @can('delete', $answer)
                            @isset($answer->deleted_at)
                                <form action="{{ route('answers.restore', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    <button class="button is-success is-icon is-rounded" type="submit">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('answers.destroy', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button is-danger is-icon is-rounded" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endisset
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
        @can('create', [App\Answer::class, $question])
            <div class="answer">
                <div class="box">
                    <form action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <div class="field">
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
        @endcan
    </div>
@endsection

@push('scripts')
    <script>
        var easyMDE = new EasyMDE({
            element: document.getElementById('emde'),
            initialValue: '',
            placeholder: 'Type your answer here',
        });
    </script>
@endpush
