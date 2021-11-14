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
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            'auth' => function () use ($request, $user) {
                return [
                    'user' => $user ? [
                        'id' => $user->id,
                        'avatar' => $user->avatar,
                        'name' => $user->user,
                        'email' => $user->email,
                        'admin' => $user->admin,
                        'status' => $user->status,
                        'biography' => $user->biography,
                        'location' => $user->location,
                        'facebook' => $user->facebook,
                        'twitter' => $user->twitter,
                        'github' => $user->github,
                        'gitlab' => $user->gitlab,
                        'instagram' => $user->instagram,
                        'notifications' => $user->unreadNotifications,
                    ] : null
                ];
            },
            'flash' => $request->session()->get('flash', [])
        ]);
    }
}
