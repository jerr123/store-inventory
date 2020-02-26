<?php

namespace App\Models\Msgboard;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $connection = 'msgboard';

    protected $fillable = [
        'user_id', 'content',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
