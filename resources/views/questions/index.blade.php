@extends('layouts.app')

@section('content')
    <div class="container">
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
                        @php
                            $colours = [
                                '#8cc63f',
                                '#d4145a',
                                '#fbb03b',
                                '#22b573',
                            ];
                        @endphp
                        <div
                            class="avatar_placeholder"
                            style="background-color: {{ $colours[rand(0, 3)] }}">
                            <h1>
                                {{ mb_substr($question->user->name, 0, 1, 'utf-8') }}
                            </h1>
                        </div>
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
                            {{ rand(0, 17) }}
                        </h1>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
