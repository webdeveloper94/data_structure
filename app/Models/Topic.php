<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lesson;
use App\Models\Test;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
