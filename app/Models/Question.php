<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Test;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_id',
        'question',
        'options',
        'correct_answer',
        'points',
        'explanation',
        'order'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
