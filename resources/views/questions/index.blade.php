@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="buttons has-text-weight-bold is-right">
                <a class="button is-primary is-uppercase" href="{{ route('questions.create') }}">
                    Ask Question
                </a>
            </div>
            <!-- TODO: Probably make a sidebar on the left side that contains the question categories -->
            <table class="table is-hoverable is-fullwidth">
                <thead>
                <tr>
                    <th>
                        Top Questions
                    </th>
                    <th>
                        User
                    </th>
                    <th>
                        Votes
                    </th>
                    <th>
                        Answers
                    </th>
                    <th>
                        Views
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>
                            <a class="title" href="{{ route('questions.show', $question->id) }}">
                                {{ $question->title }}
                            </a>
                            <div class="tags">
                                @foreach($question->tags as $tag)
                                    <a class="tag"
                                       style="background-color: {{ $tag->colour ?? '#29abe2' }}">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <img src="{{ $question->user->avatar }}"
                                 height="46px"
                                 width="46px"
                                 alt=""
                            >
                        </td>
                        <td>
                            <h1>
                                {{ $question->votes->sum('vote') }}
                            </h1>
                        </td>
                        <td>
                            <h1>
                                {{ $question->answers->count() }}
                            </h1>
                        </td>
                        <td>
                            <h1>
                                {{ views($question)->count() }}
                            </h1>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $questions->links('components.pagination') }}
        </div>
    </section>
@endsection
