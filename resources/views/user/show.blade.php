@extends('app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="box">
                <div class="columns">
                    <div class="column is-2">
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}'s avatar">
                        @if ($user->location)
                            <p>
                                Location: Portugal
                            </p>
                        @endif()
                        <p>
                            x Reputation
                        </p>
                    </div>
                    <div class="column">
                        <div class="content">
                            <h1 class="title">
                                {{ $user->name }}
                            </h1>
                            @if ($user->status)
                                <h6 class="subtitle">
                                    Status
                                </h6>
                            @endif()
                            <p>
                                {{ $user->biography }}
                            </p>
                            <div class="columns">
                                <div class="column">
                                    <h3>
                                        Top Questions
                                    </h3>
                                </div>
                                <div class="column">
                                    <h3>
                                        Top Answers
                                    </h3>
                                </div>
                            </div>
                            <div>
                                <h3>
                                    Badges
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
