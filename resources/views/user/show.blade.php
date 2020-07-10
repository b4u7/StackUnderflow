@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="box">
            <div class="columns">
                <div class="column is-2">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}'s avatar">
                </div>
                <div class="column">
                    <div class="content">
                        <h1>
                            {{ $user->name }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
