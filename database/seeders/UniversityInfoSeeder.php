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
            'lnu_hymn' => 'Beloved Leyte Normal
We sing thee hymns of praise
Loyalty and honor
To thy name embrace
            
            
Thy teachings we shall treasure
Thy words of wisdom true
So precious beyond measure
To guide our whole life through
            
            
As we sail to voyage
Life\'s uncertain seas
The haven of thy harbor safe
There we shall be
            
            
Beloved Leyte Normal
Thy name we shall adore
Thine honor ever shining
We\'ll keep forevermore

Leyte Normal University',
            'lnu_mission' => 'To produce top performing professionals equipped to engage on knowledge and technology production so necessary to develop a sustainable society.',
            'lnu_vision' => 'A leading university of education and diverse disciplines attuned to local and global development needs',
            'lnu_qualitypolicy' => 'We, at the LEYTE NORMAL UNIVERSITY (LNU), commit to pursue satisfaction of our customers through good governance, quality and relevant instruction, research, extension and support services and to continuously improve our Quality Management System in compliance with ethical standards and applicable statutory , regulatory and stakeholders’ requirements. The LNU management commits to maintain and monitor our Quality Management System and ensure availability of adequate resources.',
            'lnu_history' => 'The history of Leyte Normal University dates back to the pre-war years. 
It came into being in 1921 as the Provincial Normal School, a mere adjunct of the Leyte High School. 
It eventually outgrew its base becoming a two-year collegiate training institution in 1938. 
It became a degree-granting four-year college complete with a training department in 1952.
It was then known as Leyte Normal School.


On June 14, 1976, it was converted into the Leyte State College by virtue of Presidential Decree No. 944, signed by then Pres. Ferdinand Marcos.


In 1993, the late Cong. Cirilo Roy Montejo filed House Bill No. 22 in the House of Representatives proposing the conversion of the college into a university. 
This bill was sponsored by former Sen. Letecia Ramos-Shahani in the Senate. On February 23, 1995, the college was converted into the Leyte Normal University though R.A. 7910.


Sometime in April 1996, the university was proclaimed by the Commission on Higher Education (CHED) as the Center of Excellence for Teacher Education in Region VIII from 1996 to 2001. 
Then in August 2008, CHED again awarded LNU as Center of Excellence for Teacher Education from 2008 - 2011.'
        ]);
    }
}
