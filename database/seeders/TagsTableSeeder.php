<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['id' => 6, 'user_id' => 1, 'tagname' => 'タグなし']
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
