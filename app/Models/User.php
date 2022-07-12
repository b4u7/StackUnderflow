<?php

namespace App\Models;

use App\Events\UserCreated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Searchable, Notifiable, HasFactory;

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'username', 'has_header', 'email', 'biography', 'company', 'password', 'header_hash', 'avatar_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'header', 'avatar'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function receivesBroadcastNotificationOn(): string
    {
        return 'users.' . $this->id;
    }

    /**
     * @return HasMany<Question>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return HasMany<Answer>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return BelongsToMany<Badge>
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class);
    }

    /**
     * @return BelongsToMany<Question>
     */
    public function bookmarkedQuestions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'user_question_bookmark')->using(Bookmark::class);
    }

    protected function header(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->has_header) {
                return null;
            }

            return Storage::cloud()->url("users/headers/$this->id.jpeg") . "?$this->header_hash";
        });
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(fn() => Storage::cloud()->url("users/avatars/$this->id.jpeg") . "?$this->avatar_hash");
    }
}
