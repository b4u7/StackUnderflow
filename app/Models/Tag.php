<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'colour'
    ];

    private const COLOURS = [
        'slate',
        'gray',
        'zinc',
        'neutral',
        'stone',
        'red',
        'orange',
        'amber',
        'yellow',
        'lime',
        'green',
        'emerald',
        'teal',
        'cyan',
        'sky',
        'indigo',
        'violet',
        'purple',
        'fuchsia',
        'pink',
        'rose'
    ];

    /**
     * @return BelongsToMany<Question>
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

    /**
     * @return Attribute<>
     */
    public function colour(): Attribute
    {
        return Attribute::get(fn($colour) => $colour ?? self::COLOURS[crc32($this->name) % count(self::COLOURS)]);
    }
}
