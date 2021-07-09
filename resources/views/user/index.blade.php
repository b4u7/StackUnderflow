@extends('app')

@section('content')
    <section class="section">
        <div class="container">
            <div class="buttons has-text-weight-bold is-right">
                <a class="button is-primary is-uppercase" href="{{ route('questions.index') }}">
                    Go back
                </a>
            </div>
            <div
                class="columns is-variable is-2-mobile is-2-tablet is-2-desktop is-3-widescreen is-3-fullhd is-multiline">
                @foreach ($users as $user)
                    {{-- is-variable is-1-mobile is-1-tablet is-1-desktop is-2-widescreen is-2-fullhd --}}
                    <div class="column is-1">
                        <div class="card">
                            <div class="card-header">
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}'s Avatar">
                            </div>
                            <div class="card-content">
                                <div class="content">
                                    <p>
                                        Reputation
                                    </p>
                                    @if ($user->location)
                                        <p>
                                            {{ $user->location }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $users->links('components.pagination') }}
        </div>
    </section>
@endsection
