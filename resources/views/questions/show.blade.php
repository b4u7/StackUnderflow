@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="question">
                <div class="question__header">
                    <h1>
                        {{ $question->title }}
                    </h1>
                </div>
                <div class="question__body">
                </div>
            </div>

            <div class="answers">

            </div>
        </div>
    </div>
@endsection
