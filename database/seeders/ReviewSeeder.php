<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::create([
            'emoji' => 'Satisfied',
            'suggestion' => 'I am happy that you were able to come up with this idea. Just do your best. Good Luck!',
        ]);

        Rating::create([
            'emoji' => 'Needs improvement',
            'suggestion' => 'I wasn\'t able to run this smoothly on my device. Please make a support for low-end devices.',
        ]);

        Rating::create([
            'emoji' => 'Needs improvement',
            'suggestion' => 'Running a machine learning model like this with a lot of data needs a high-end computer. My computer can\'t run this smoothly.',
        ]);

        Rating::create([
            'emoji' => 'Surprised',
            'suggestion' => 'I was surprised with this system. This is new for me. Hope you continue to develop this.',
        ]);

        Rating::create([
            'emoji' => 'Awesome',
            'suggestion' => 'This is a fun project to do. You\'re team is great.',
        ]);

        Rating::create([
            'emoji' => 'Needs improvement',
            'suggestion' => 'Nakakangalay sa kamay. Medyo mahirap mag adapat sa controls',
        ]);

        Rating::create([
            'emoji' => 'happy',
            'suggestion' => 'This is a sample review from a user. Data are collected anonymously',
        ]);
    }
}
