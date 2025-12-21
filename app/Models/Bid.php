<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bids';

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function bidder()
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }
}
