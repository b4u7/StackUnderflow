<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Safe\Exceptions\UrlException;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     * @throws UrlException
     */
    public function update(mixed $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'header' => [
                'image',
                'max:8192',
            ],
            'avatar' => [
                'nullable',
                'image',
                'max:4096',
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
            $user->forceFill(
                Arr::only($input, ['name', 'email', 'biography', 'company'])
            )->save();
        }

        if (array_key_exists('avatar', $input) && $input['avatar'] !== null) {
            $avatar = $input['avatar'];
            $avatarHash = md5_file($avatar);

            Storage::cloud()->putFileAs('users/avatars', $avatar, "$user->id.jpeg", 'public');
            $user->update(['avatar_hash' => $avatarHash]);
        }

        if (!array_key_exists('header', $input)) {
            return;
        }

        $header = $input['header'];
        if ($header === null) {
            Storage::cloud()->delete("users/headers/$user->id.jpeg");

            $user->update(['has_header' => false]);

            return;
        }

        $headerHash = md5_file($header);

        Storage::cloud()->putFileAs('users/headers', $header, "$user->id.jpeg", 'public');
        $user->update(['header_hash' => $headerHash, 'has_header' => true]);
    }

    /**
     * Update the given verified user's profile information.
     */
    protected function updateVerifiedUser(mixed $user, array $input): void
    {
        $user->forceFill(
            array_merge(
                ['email_verified_at' => null],
                Arr::only($input, ['name', 'email', 'biography', 'company'])
            )
        )->save();

        $user->sendEmailVerificationNotification();
    }
}
