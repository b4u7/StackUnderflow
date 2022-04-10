<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request): RedirectResponse
            {
                return redirect()->route('verification.notice');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::query()
                ->where('email', $request->input('username'))
                ->orWhere('username', $request->input('username'))
                ->first();

            if ($user &&
                Hash::check($request->input('password'), $user->password)) {
                return $user;
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for(
            'login',
            static fn(Request $request) => Limit::perMinute(5)->by($request->username . $request->ip())
        );

        Fortify::loginView(static fn() => Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]));

        Fortify::registerView(static fn() => Inertia::render('Auth/Register'));

        Fortify::verifyEmailView(static fn() => Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
        ]));

        // TODO: Auth/Passwords/ForgotPassword
        Fortify::requestPasswordResetLinkView(static fn() => Inertia::render('Auth/Passwords/ForgotPassword', [
            'status' => session('status')
        ]));

        // TODO: Auth/Passwords/ResetPassword
        Fortify::resetPasswordView(static fn(Request $request) => Inertia::render('Auth/Passwords/ResetPassword', [
            'token' => $request->route('token')
        ]));
    }
}
