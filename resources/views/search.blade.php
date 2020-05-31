@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Todo: Edit this later -->
        <h5 style="margin-bottom: 10px;">
            Search results for "{{ Request::get('search') }}"
        </h5>
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
                        <!-- TODO: Avatars -->
                        <img src="{{ Avatar::create($question->user->name)->toBase64() }}"
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
                            {{ rand(0, 17) }}
                        </h1>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
