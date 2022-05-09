<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            'auth' => function () use ($request, $user) {
                return [
                    'user' => optional($user, static fn() => [
                        'id' => $user->id,
                        'avatar' => $user->avatar,
                        'admin' => $user->admin,
                        'notifications' => $user->unreadNotifications,
                    ])
                ];
            },
            'flash' => $request->session()->get('flash', [])
        ]);
    }
}
