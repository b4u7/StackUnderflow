<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     */
    public function update(mixed $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'header' => [
                'image',
                'max:8192',
                'dimensions:min_width=1024,min_height=1024',
            ],
            'avatar' => [
                'nullable',
                'image',
                'max:4096',
                'dimensions:min_width=256,min_height=256',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'biography' => [
                'nullable',
                'string',
                'max:160'
            ],
            'company' => [
                'nullable',
                'string',
                'max:40'
            ],
        ])->validate();

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'biography' => $input['biography'],
                'company' => $input['company'],
            ])->save();
        }

        if (!empty($input['avatar'])) {
            Storage::disk('public')->putFileAs('users/avatars', $input['avatar'], "$user->id.jpeg");
        }

        if (!array_key_exists('header', $input)) {
            return;
        }

        $header = $input['header'];
        if ($header === null) {
            Storage::disk('public')->delete("users/headers/$user->id.jpeg");

            $user->update(['has_header' => false]);

            return;
        }

        Storage::disk('public')->putFileAs('users/headers', $header, "$user->id.jpeg");
        $user->update(['has_header' => true]);
    }

    /**
     * Update the given verified user's profile information.
     */
    protected function updateVerifiedUser(mixed $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'biography' => $input['biography'],
            'company' => $input['company'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
