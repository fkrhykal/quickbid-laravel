<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasUuids;

    protected $table = 'items';

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
    ];

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
}
