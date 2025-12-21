<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasUuids;

    protected $table = 'auctions';

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'status',
        'starting_bid',
    ];

    public function lister()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
