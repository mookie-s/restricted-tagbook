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
            ['id' => 1, 'user_id' => 1, 'tagname' => '日記', 'abbreviation' => '日記'],
            ['id' => 2, 'user_id' => 1, 'tagname' => 'オフライン活動', 'abbreviation' => 'オフ活'],
            ['id' => 3, 'user_id' => 1, 'tagname' => 'イラスト', 'abbreviation' => 'イラスト'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
