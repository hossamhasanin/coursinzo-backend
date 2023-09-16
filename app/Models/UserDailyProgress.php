<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class UserDailyProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "date",
        "minutes"
    ];

    protected $casts = [
        "date" => "datetime"
    ];

//    protected function getDateAttribute() {
//        return Carbon::createFromFormat("Y-m-d" , $this->attributes["date"]);
//    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
