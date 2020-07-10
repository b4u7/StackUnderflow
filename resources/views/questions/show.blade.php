@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="content">
                <div class="buttons has-text-weight-bold is-right">
                    <a class="button is-primary is-uppercase" href="{{ route('questions.show', $question->id) }}">
                        Go back
                    </a>
                </div>
                <div class="columns is-vcentered">
                    <div class="column has-text-centered is-narrow">
                        <form action="{{ route('questions.upvote', $question) }}" method="POST">
                            @csrf
                            <button
                                class="button vote-button vote-button-positive is-icon is-rounded is-large @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) is-active @endif"
                                type="submit"
                            >
                                <span class="icon is-large">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </span>
                            </button>
                        </form>
                        <div>
                            <p>
                                {{ $question->votes_sum ?? 0 }}
                            </p>
                        </div>
                        <form action="{{ route('questions.downvote', $question) }}" method="POST">
                            @csrf
                            <button
                                class="button vote-button vote-button-negative is-icon is-rounded is-large @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '-1')->count() === 1) is-active @endif"
                                type="submit"
                            >
                                <span class="icon is-large">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="column">
                        <div class="box">
                            <div class="card">
                                <div class="card-header">
                                    <div class="content">
                                        <h6 class="subtitle is-uppercase">
                                            Question
                                        </h6>
                                        <h1 class="title">
                                            {{ $question->title }}
                                        </h1>
                                        <div class="tags">
                                            @foreach($question->tags as $tag)
                                                <a class="tag"
                                                   style="border-color: {{ $tag->colour ?? '#29abe2' }}; color: {{ $tag->colour ?? '#29abe2' }};">
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="content">
                                        @parsedown($question->body)
                                    </div>
                                </div>
                                <div class="card-foot">
                                    <div class="columns is-vcentered">
                                        <div class="card-foot-actions column is-auto">
                                            <a id="actionShare">
                                                Share
                                            </a>
                                            @can('update', $question)
                                                <a href="{{ route('questions.edit', $question->id) }}">
                                                    Edit
                                                </a>
                                            @endcan
                                            @can('delete', $question)
                                                <form class="form"
                                                      action="{{ route('questions.destroy', $question->id) }}"
                                                      method="POST"
                                                >
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="javascript:{}" onclick="this.parentElement.submit();">
                                                        Delete
                                                    </a>
                                                </form>
                                            @endcan
                                        </div>
                                        <div class="card-foot-user column has-text-right is-narrow">
                                            <img class="user-avatar"
                                                 src="{{ $question->user->avatar }}"
                                                 alt="{{ $question->user->name }}'s user avatar"
                                            >
                                            <p>
                                                Asked by
                                                <a href="{{ route('user.show', $question->user) }}">
                                                    {{ $question->user->name }}
                                                </a>
                                                at {{ $question->created_at->format('jS F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="has-text-right">
                    {{ count($answers) }} Answer(s)
                </h1>
                <div class="box">
                    @foreach ($answers as $answer)
                        <div class="columns answers @if($answer->trashed()) trashed @endif">
                            <div class="column has-text-centered is-narrow">
                                <form action="{{ route('answers.upvote', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="button vote-button vote-button-positive is-icon is-rounded is-large @if($answer->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) is-active @endif"
                                        type="submit"
                                    >
                                        <span class="icon is-large">
                                            <i class="fas fa-arrow-circle-up"></i>
                                        </span>
                                    </button>
                                </form>
                                <div>
                                    <p>
                                        {{ $answer->votes_sum ?? 0 }}
                                    </p>
                                </div>
                                <form action="{{ route('answers.downvote', [$question, $answer]) }}" method="POST">
                                    @csrf
                                    <button
                                        class="button vote-button vote-button-negative is-icon is-rounded is-large @if($answer->votes->where('user_id', '=', Auth::id())->where('vote', '=', '-1')->count() === 1) is-active @endif"
                                        type="submit"
                                    >
                                        <span class="icon ">
                                            <i class="fas fa-arrow-circle-down"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                            <div class="column">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="content">
                                            @parsedown($answer->body)
                                        </div>
                                    </div>
                                    <div class="card-foot">
                                        <div class="columns is-vcentered">
                                            <div class="card-foot-actions column is-auto">
                                                @can('update', $answer)
                                                    <a href="{{ route('answers.edit', [$question, $answer]) }}">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete', $answer)
                                                    <form class="form"
                                                          action="{{ route('answers.destroy', [$question, $answer]) }}"
                                                          method="POST"
                                                    >
                                                        @method('DELETE')
                                                        @csrf
                                                        <a href="javascript:{}" onclick="this.parentElement.submit();">
                                                            Delete
                                                        </a>
                                                    </form>
                                                @endcan
                                            </div>
                                            <div class="card-foot-user column has-text-right is-narrow">
                                                <img class="user-avatar"
                                                     src="{{ $answer->user->avatar }}"
                                                     alt="{{ $answer->user->name }}'s user avatar"
                                                >
                                                <p>
                                                    Answered by
                                                    <a href="{{ route('user.show', $answer->user) }}">
                                                        {{ $answer->user->name }}
                                                    </a>
                                                    at {{ $answer->created_at->format('jS F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @can('create', [App\Answer::class, $question])
                <div class="answer">
                    <div class="content mb-0">
                        <h3>
                            Post your answer
                        </h3>
                    </div>
                    <div class="box">
                        <div class="content">
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
                                            Submit your answer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </section>
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
