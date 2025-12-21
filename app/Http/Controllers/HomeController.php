<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return inertia()->render('Home', [
            'categories' => Inertia::once(fn () => Category::all(['id', 'name'])),
        ]);
    }
}
