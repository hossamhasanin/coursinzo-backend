<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        "video",
        "name",
        "description",
        "thumbnail",
        "duration",
        "course_id"
    ];

    protected $casts = [
        "video" => "array"
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
