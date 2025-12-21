<?php

namespace Database\Seeders;

use App\Models\Picture;
use Illuminate\Database\Seeder;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pictures = [
            ['url' => 'https://picsum.photos/id/10/800/600'],
            ['url' => 'https://picsum.photos/id/20/800/600'],
            ['url' => 'https://picsum.photos/id/30/800/600'],
            ['url' => 'https://picsum.photos/id/40/800/600'],
            ['url' => 'https://picsum.photos/id/50/800/600'],
        ];

        Picture::fillAndInsert($pictures);
    }
}
