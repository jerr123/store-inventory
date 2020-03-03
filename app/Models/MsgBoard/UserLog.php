<?php

namespace App\Models\Msgboard;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{

    protected $connection = 'msgboard';
    protected $table = 'user_logs';

    protected $fillable = [
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
