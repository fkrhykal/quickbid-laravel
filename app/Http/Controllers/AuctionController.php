<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Picture;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuctionController extends Controller
{
    public function showPlaceAuction(Request $request)
    {
        return Inertia::render('Auction/PlaceAuction', [
            'categories' => fn () => Category::all(['id', 'name']),
            // 'pictures' => fn () => Picture::query()
            //     ->where('owner_id', $request->user()->id)
            //     ->all(['url']),
        ]);
    }
}
