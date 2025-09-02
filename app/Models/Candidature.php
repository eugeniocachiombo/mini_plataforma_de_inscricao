<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $fillable = [
        "code",
        "program_id",
        "user_id",
    ];

    public function program(){
        return $this->belongsTo(Program::class, "program_id", "id");
    }

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
