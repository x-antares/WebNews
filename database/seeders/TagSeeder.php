<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'name' => 'art',
        ]);

        Tag::create([
            'name' => 'amazing',
        ]);

        Tag::create([
            'name' => 'interesting'
        ]);

        Tag::create([
            'name' => 'great'
        ]);

        Tag::create([
            'name' => 'awesome'
        ]);

        Tag::create([
            'name' => 'wow'
        ]);

        DB::table('taggables')->insert([
            'tag_id' => 1,
            'taggable_id' => 1,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => 2,
            'taggable_id' => 2,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => 3,
            'taggable_id' => 3,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => 4,
            'taggable_id' => 4,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => 5,
            'taggable_id' => 4,
            'taggable_type' => 'App\Models\News',
        ]);
    }
}
