@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content box">
            <h1 class="title">
                {{ _('Login') }}
            </h1>

            <div class="">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="field">
                        <label class="label">
                            Email
                        </label>
                        <div class="control">
                            <input id="email"
                                   class="input @error('email') is-danger @enderror"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="example@stackunderflow.com"
                                   required
                                   autocomplete="email"
                                   autofocus
                            >
                        </div>
                        @error('email')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">
                            Password
                        </label>
                        <div class="control">
                            <input id="password"
                                   class="input @error('password') is-danger @enderror"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                            >
                        </div>
                        @error('password')
                        <p class="help is-danger">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input id="remember"
                                       type="checkbox"
                                       name="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                {{ _('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ _('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
