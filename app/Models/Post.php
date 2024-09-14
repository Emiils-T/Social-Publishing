<?php

namespace App\Models;

use App\Helpers\XssPreventionHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = XssPreventionHelper::clean($value);
    }

    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = XssPreventionHelper::sanitizeHtml($value);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
