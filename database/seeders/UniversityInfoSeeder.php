<?php

namespace Database\Seeders;

use App\Models\UniversityInfo;
use Illuminate\Database\Seeder;

class UniversityInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UniversityInfo::create([
            'lnu_hymn' => '<p>Beloved Leyte Normal</p> 
                        <p>We sing thee hymns of praise</p>
                        <p>Loyalty and honor</p> 
                        <p>To thy name embrace</p> <br/>
                        <p>Thy teachings we shall treasure</p>
                        <p>Thy words of wisdom true</p>
                        <p>So precious beyond measure</p>
                        <p>To guide our whole life through</p><br/>
                        <p>As we sail to voyage</p>
                        <p>Life\'s uncertain seas</p>
                        <p>The haven of thy harbor safe</p>
                        <p>There we shall be</p><br/>
                        <p>Beloved Leyte Normal</p>
                        <p>Thy name we shall adore</p>
                        <p>Thine honor ever shining</p>
                        <p>We\'ll keep forevermore</p><br/>
                        <p>Leyte Normal University</p>',
            'lnu_mission' => 'To produce top performing professionals equipped to engage on knowledge and technology production so necessary to develop a sustainable society.',
            'lnu_vision' => 'A leading university of education and diverse disciplines attuned to local and global development needs'
        ]);
    }
}
