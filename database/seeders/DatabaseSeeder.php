<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        News::create([
            'name' => 'Synthwave',
            'text' => 'Synthwave (also called outrun, retrowave, or futuresynth) is an electronic music microgenre that is based predominantly on the music associated with action, science-fiction, and horror film soundtracks of the 1980s. Other influences are drawn from that decade\'s art and video games. Synthwave musicians often espouse nostalgia for 1980s culture and attempt to capture the era\'s atmosphere and celebrate it. The genre developed in the mid-to late 2000s through French house producers, as well as younger artists who were inspired by the 2002 video game Grand Theft Auto: Vice City. Other reference points included composers John Carpenter, Jean-Michel Jarre, Vangelis (especially his score for the 1982 film Blade Runner), and Tangerine Dream.',
            'image_name' => 'synthwave.jpg',
            'image_path' => '/seed_image/synthwave.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Lorem ipson',
            'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'image_name' => NULL,
            'image_path' => NULL,
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Art Deco',
            'text' => 'Art Deco, sometimes referred to as Deco, is a style of visual arts, architecture and design that first appeared in France just before World War I. Art Deco influenced the design of buildings, furniture, jewelry, fashion, cars, movie theatres, trains, ocean liners, and everyday objects such as radios and vacuum cleaners. It took its name, short for Arts Décoratifs, from the Exposition internationale des arts décoratifs et industriels modernes (International Exhibition of Modern Decorative and Industrial Arts) held in Paris in 1925. It combined modern styles with fine craftsmanship and rich materials. During its heyday, Art Deco represented luxury, glamour, exuberance, and faith in social and technological progress.',
            'image_name' => 'art_deco.jpg',
            'image_path' => '/seed_image/art_deco.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Cyberpunk',
            'text' => 'Cyberpunk is a subgenre of science fiction in a dystopian futuristic setting that tends to focus on a "combination of lowlife and high tech" featuring advanced technological and scientific achievements, such as artificial intelligence and cybernetics, juxtaposed with a degree of breakdown or radical change in the social order. Much of cyberpunk is rooted in the New Wave science fiction movement of the 1960s and 1970s, when writers like Philip K. Dick, Roger Zelazny, John Brunner, J. G. Ballard, Philip José Farmer and Harlan Ellison examined the impact of drug culture, technology, and the sexual revolution while avoiding the utopian tendencies of earlier science fiction.',
            'image_name' => 'cyberpunk.jpg',
            'image_path' => '/seed_image/cyberpunk.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Futurism',
            'text' => 'Futurism was an artistic and social movement that originated in Italy in the early 20th century.  It emphasized dynamism, speed, technology, youth, violence, and objects such as the car, the airplane, and the industrial city.',
            'image_name' => 'futurism.jpg',
            'image_path' => '/seed_image/futurism.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Neon lighting',
            'text' => 'Neon lighting consists of brightly glowing, electrified glass tubes or bulbs that contain rarefied neon or other gases. Neon lights are a type of cold cathode gas-discharge light. A neon tube is a sealed glass tube with a metal electrode at each end, filled with one of a number of gases at low pressure. A high potential of several thousand volts applied to the electrodes ionizes the gas in the tube, causing it to emit colored light. The color of the light depends on the gas in the tube.',
            'image_name' => 'neon.jpg',
            'image_path' => '/seed_image/neon.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Pix art',
            'text' => 'Pixart started in 1998 as a regional representative of Corel in Latin America. When Corel discontinued their operating system product, Pixart decided to continue the project, receiving technical and legal support from Corel. Corel gave the English version of their operating system to Xandros, and agreed to give the Spanish and Portuguese versions to Pixart. These products, coupled with many sales agreements, have made Pixart one of the largest Linux-related companies in Latin America.',
            'image_name' => 'pixart.jpg',
            'image_path' => '/seed_image/pixart.jpg',
            'active' => boolval(true)
        ]);

        News::create([
            'name' => 'Future',
            'text' => 'The future is the time after the present. Its arrival is considered inevitable due to the existence of time and the laws of physics. Due to the apparent nature of reality and the unavoidability of the future, everything that currently exists and will exist can be categorized as either permanent, meaning that it will exist forever, or temporary, meaning that it will end. In the Occidental view, which uses a linear conception of time, the future is the portion of the projected timeline that is anticipated to occur. In special relativity, the future is considered absolute future, or the future light cone',
            'image_name' => 'future.jpg',
            'image_path' => '/seed_image/future.jpg',
            'active' => boolval(true)
        ]);

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
            'tag_id' => Tag::all()->random()->id,
            'taggable_id' => News::all()->random()->id,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => Tag::all()->random()->id,
            'taggable_id' => News::all()->random()->id,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => Tag::all()->random()->id,
            'taggable_id' => News::all()->random()->id,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => Tag::all()->random()->id,
            'taggable_id' => News::all()->random()->id,
            'taggable_type' => 'App\Models\News',
        ]);

        DB::table('taggables')->insert([
            'tag_id' => Tag::all()->random()->id,
            'taggable_id' => News::all()->random()->id,
            'taggable_type' => 'App\Models\News',
        ]);
    }
}
