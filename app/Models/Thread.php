<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    public function path()
    {
        return route('threads.show', $this);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
