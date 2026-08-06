<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
