<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Topic;
use App\Models\Lab;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'topic_id',
        'description',
        'content',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function labs(): HasMany
    {
        return $this->hasMany(Lab::class);
    }
}
