<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'starts_at',
        'ends_at',
        'created_by',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function participants()
    {
        return $this->belongsToMany(Participant::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}