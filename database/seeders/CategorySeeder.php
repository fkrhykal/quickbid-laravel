<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion'],
            ['name' => 'Home & Garden'],
            ['name' => 'Sports & Outdoors'],
            ['name' => 'Toys & Hobbies'],
            ['name' => 'Automotive'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Books & Media'],
            ['name' => 'Collectibles & Art'],
            ['name' => 'Industrial & Business'],
        ];

        Category::fillAndInsert($categories);
    }
}
