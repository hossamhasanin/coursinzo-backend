<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "user_id",
        "thumbnail"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lessons() {
        return $this->hasMany(Lesson::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
