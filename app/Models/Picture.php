<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';

    protected $fillable = [
        'url',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
