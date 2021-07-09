@extends('app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="content">
                <div class="mb-8">
                    <a class="button button--fullwidth-touch" href="{{ route('questions.show', $question->id) }}">
                        Go back
                    </a>
                </div>

                @if ($question->trashed())
                    <div class="alert alert--danger my-8">
                        This question was deleted, only admins can see it.
                    </div>
                @endif

                <div class="flex flex-row"> <!--items-center-->
                    <div class="question-controls">
                        <form action="{{ route('questions.upvote', $question) }}" method="POST">
                            @csrf
                            <button
                                class="question-controls__vote-up @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) question-controls__vote-up--active @endif"
                                type="submit"
                                @cannot('vote', $question)
                                disabled
                                @endcannot
                            >
                                <i class="fas fa-angle-up"></i>
                            </button>
                        </form>
                        <p class="question-controls__vote-count">
                            @if ($question->votes_sum)
                                <span class="@if (0 < $question->votes_sum) text-green-600 @elseif ($question->votes_sum < 0) text-red-600 @endif">
                                    {{ $question->votes_sum }}
                                </span>
                            @else
                                0
                            @endif
                        </p>
                        <form action="{{ route('questions.downvote', $question) }}" method="POST">
                            @csrf
                            <button
                                class="question-controls__vote-down @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '-1')->count() === 1) question-controls__vote-down--active @endif"
                                type="submit"
                                @cannot('vote', $question)
                                disabled
                                @endcannot
                            >
                                <i class="fas fa-angle-down"></i>
                            </button>
                        </form>
                        @if ($bookmarked)
                            <form action="{{ route('questions.bookmark', $question) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="question-controls__bookmark question-controls__bookmark--active"
                                    type="submit"
                                    @cannot('create', [App\Models\Bookmark::class, $question])
                                    disabled
                                    @endcan
                                >
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('questions.bookmark', $question) }}" method="POST">
                                @csrf
                                <button
                                    class="question-controls__bookmark"
                                    type="submit"
                                    @cannot('create', [App\Models\Bookmark::class, $question])
                                    disabled
                                    @endcan
                                >
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </form>
                        @endcan
                    </div>
                    <div class="question-card card">
                        <div class="question-card__header card__header">
                            <h1 class="question-card__title">
                                {{ $question->title }}
                            </h1>
                            <div class="question-card__stats">
                                <p>
                                    @if ($question->answers->count() > 0 && $question->answers->last()->created_at > $question->updated_at)
                                        Answered
                                        <span class="text-gray-700 font-medium">
                                            {{ $question->answers->last()->created_at->diffForHumans() }}
                                        </span>
                                    @elseif($question->updated_at)
                                        Modified
                                        <span class="text-gray-700 font-medium">
                                            {{ $question->updated_at->diffForHumans() }}
                                        </span>
                                    @else
                                        Asked
                                        <span class="text-gray-700 font-medium">
                                            {{ $question->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </p>
                                <p>
                                    viewed
                                    <span class="text-gray-700 font-medium">
                                        {{ views($question)->count() }} times
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="question-card__body card__content">
                            <p>
                                {{ $question->body }}
                            </p>
                        </div>
                        @if ($question->tags->count())
                            <div class="question-card__tags tags">
                                @foreach ($question->tags as $tag)
                                    <div class="tag">
                                        {{ $tag->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="question-card__footer card__footer">
                            <div class="question-card__menu">
                                <a>
                                    Share
                                </a>
                                @can('edit', $question)
                                    <a href="{{ route('questions.edit', $question->id) }}">
                                        Edit
                                    </a>
                                @endcan
                                @can('delete', $question)
                                    <form class="form"
                                          action="{{ route('questions.destroy', $question) }}"
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
                            <div class="question-card__user">
                                <div>
                                    <p>
                                        <a class="question-card__user-name"
                                           href="{{ route('user.show', $question->user) }}">
                                            {{ $question->user->name }}
                                        </a>
                                    </p>
                                    <p>
                                        Asked {{ $question->created_at->format('d M, Y H:i') }}
                                    </p>
                                </div>
                                <a href="{{ route('user.show', $question->user) }}">
                                    <img class="question-card__user-avatar"
                                         src="{{ $question->user->avatar }}"
                                         alt="{{ $question->user->name }}'s Avatar"
                                    >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-12 mb-4 text-gray-800 text-xl font-medium">
                    <i class="fas fa-comment-alt"></i> {{ $question->answers->count() }} Answers
                </p>

                @foreach($answers as $answer)
                    <div class="answer-card card">
                        test
                    </div>
            @endforeach
            <!-- Old -->
                <div class="columns is-vcentered">
                    <div class="column has-text-centered is-narrow">
                        <form action="{{ route('questions.upvote', $question) }}" method="POST">
                            @csrf
                            <button
                                class="button vote-button vote-button-positive is-icon is-rounded is-large @if($question->votes->where('user_id', '=', Auth::id())->where('vote', '=', '1')->count() === 1) is-active @endif"
                                type="submit"
                                @cannot('vote', $question)
                                disabled
                                @endcannot
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
                                @cannot('vote', $question)
                                disabled
                                @endcannot
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
                                        @cannot('vote', $answer)
                                        disabled
                                        @endcannot
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
                                        @cannot('vote', $answer)
                                        disabled
                                        @endcannot
                                    >
                                        <span class="icon">
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
                                                @can('solution', $answer)
                                                    <form class="form"
                                                          action="{{ route('answers.solution', [$question, $answer]) }}"
                                                          method="POST"
                                                    >
                                                        @csrf
                                                        <a id="solveForm" href="javascript: submitForm()">
                                                            Mark as solution
                                                        </a>
                                                    </form>
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
        let easyMDE = new EasyMDE({
            element: document.getElementById('emde'),
            placeholder: 'Type here...',
            initialValue: '',
            hideIcons: ['guide', 'fullscreen', 'side-by-side'],
            tabSize: 4
        })

        console.log('test')
    </script>
@endpush
