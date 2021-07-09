@extends('app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="mr-0 mb-4 text-right">
                <a class="button button--fullwidth-touch" href="{{ route('questions.create') }}">
                    Ask Question
                </a>
            </div>
            <!-- TODO: Left sidebar with some question categories -->
            <table class="table">
                <thead class="table__head">
                <tr>
                    <th scope="col" class="table__header">
                        Top Questions
                    </th>
                    <th scope="col" class="table__header">
                        User
                    </th>
                    <th scope="col" class="table__header">
                        <i class="fas fa-pencil-alt"></i> Answers
                    </th>
                    <th scope="col" class="table__header">
                        <i class="fas fa-sort"></i> Votes
                    </th>
                    <th scope="col" class="table__header">
                        <i class="fas fa-eye"></i> Views
                    </th>
                </tr>
                </thead>
                <tbody class="table__body">
                @foreach ($questions as $question)
                    <tr>
                        <td class="table__data">
                            <a class="font-medium" href="{{ route("questions.show", $question->id) }}">
                                {{ $question->title }}
                            </a>
                            <div class="tags">
                                @foreach($question->tags as $tag)
                                    <a class="tag"
                                       style="background-color: {{ $tag->colour ?? '29abe2' }}">dis
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </td>
                        <td class="table__data">
                            <a href="{{ route('user.show', $question->user) }}">
                                <img src="{{ $question->user->avatar }}"
                                     height="46px"
                                     width="46px"
                                     alt=""
                                >
                            </a>
                        </td>
                        <td class="table__data">
                            <h1 class="{{ $question->answers->count() == 0 ? 'opacity-50' : 'text-green-700' }} font-medium">
                                {{ $question->answers->count() }}
                            </h1>
                        </td>
                        <td class="table__data">
                            <h1 class="font-medium">
                                {{ $question->votes->sum("vote") }}
                            </h1>
                        </td>
                        <td class="table__data">
                            <h1 class="font-medium">
                                {{ views($question)->count() }}
                            </h1>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="questions-feed mt-8">
                @foreach ($questions as $question)
                    <div class="questions-feed__card card">
                        <div class="questions-feed__header card__header">
                            <div class="questions-feed__user">
                                <a href="{{ route('user.show', $question->user) }}">
                                    <img class="questions-feed__user-avatar"
                                         src="{{ $question->user->avatar }}"
                                         alt="{{ $question->user->name }}'s Avatar"
                                    >
                                </a>
                                <div>
                                    <p>
                                        <a class="questions-feed__user-name"
                                           href="{{ route('user.show', $question->user) }}">
                                            {{ $question->user->name }}
                                        </a>
                                    </p>
                                    <p>
                                        @if ($question->answers->count() > 0 && $question->answers->last()->created_at > $question->updated_at)
                                            Answered {{ $question->answers->last()->created_at->diffForHumans() }}
                                        @elseif($question->updated_at)
                                            Modified {{ $question->updated_at->diffForHumans() }}
                                        @else
                                            Asked {{ $question->created_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="questions-feed__content card__content">
                            <h1 class="questions-feed__title">
                                <a href="{{ route('questions.show', $question->id) }}">
                                    {{ $question->title }}
                                </a>
                            </h1>
                            <p class="questions-feed__body">
                                {{ Str::limit($question->body, 100, "...") }}
                            </p>
                        </div>
                        @if ($question->tags->count())
                            <div class="questions-feed__tags tags">
                                @foreach ($question->tags as $tag)
                                    <div class="tag">
                                        {{ $tag->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="questions-feed__footer card__footer">
                            <div class="questions-feed__stats">
                                <p>
                                    <i class="fas fa-comment-alt"></i> {{ $question->answers->count() }}
                                </p>
                                <p class="@if ($question->votes->sum("vote") > 0) text-green-600 @elseif ($question->votes->sum("vote") < 0) text-red-600 @endif">
                                    <i class="fas fa-sort"></i> {{ $question->votes->sum("vote") }}
                                </p>
                                <p>
                                    <i class="fas fa-eye"></i> {{ views($question)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $questions->links('components.pagination') }}
        </div>
    </section>
@endsection
