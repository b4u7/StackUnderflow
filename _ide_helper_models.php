<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Answer
 *
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read Question $question
 * @property-read User $user
 * @property-read Collection|Vote[] $votes
 * @property-read int|null $votes_count
 * @method static Builder|Answer newModelQuery()
 * @method static Builder|Answer newQuery()
 * @method static Builder|Answer query()
 * @method static Builder|Answer whereBody($value)
 * @method static Builder|Answer whereCreatedAt($value)
 * @method static Builder|Answer whereId($value)
 * @method static Builder|Answer whereQuestionId($value)
 * @method static Builder|Answer whereUpdatedAt($value)
 * @method static Builder|Answer whereUserId($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Answer onlyTrashed()
 * @method static Builder|Answer whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Answer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Answer withoutTrashed()
 */
	class Answer extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property int $commentable_id
 * @property string $commentable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $commentable
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereBody($value)
 * @method static Builder|Comment whereCommentableId($value)
 * @method static Builder|Comment whereCommentableType($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 * @mixin Eloquent
 * @property string|null $deleted_at
 * @method static Builder|\App\Comment whereDeletedAt($value)
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Question
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read Collection|Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read User $user
 * @property-read Collection|Vote[] $votes
 * @property-read int|null $votes_count
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereBody($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereTitle($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @method static Builder|Question whereUserId($value)
 * @mixin Eloquent
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Question onlyTrashed()
 * @method static Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Question withoutTrashed()
 */
	class Question extends \Eloquent {}
}

namespace App{
/**
 * App\Tag
 *
 * @property-read Collection|Question[] $questions
 * @property-read int|null $questions_count
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $colour
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tag whereColour($value)
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereName($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Question[] $questions
 * @property-read int|null $questions_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property bool $admin
 * @method static Builder|User whereAdmin($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Vote
 *
 * @property int $id
 * @property int $user_id
 * @property int $vote
 * @property int $votable_id
 * @property string $votable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $votable
 * @method static Builder|Vote newModelQuery()
 * @method static Builder|Vote newQuery()
 * @method static Builder|Vote query()
 * @method static Builder|Vote whereCreatedAt($value)
 * @method static Builder|Vote whereId($value)
 * @method static Builder|Vote whereUpdatedAt($value)
 * @method static Builder|Vote whereUserId($value)
 * @method static Builder|Vote whereVotableId($value)
 * @method static Builder|Vote whereVotableType($value)
 * @method static Builder|Vote whereVote($value)
 * @mixin Eloquent
 */
	class Vote extends \Eloquent {}
}

