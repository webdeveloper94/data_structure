<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Topic;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'content',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
