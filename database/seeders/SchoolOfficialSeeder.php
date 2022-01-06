<?php

namespace Database\Seeders;

use App\Models\SchoolOfficials;
use Illuminate\Database\Seeder;

class SchoolOfficialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'image' => 'Aguirre, Evelyn 101.jpg',
                'title' => 'Dr.',
                'first_name' => 'Evelyn',
                'middle_name' => 'B',
                'last_name' => 'Aguirre',
                'gender' => 'Female',
                'role' => 'University President',
                'email' => 'president@lnu.edu.ph',
                'telephone' => '+63 53 832 - 3205',
            ],
            [
                
                'title' => 'Dr. Ma.',
                'first_name' => 'Rocini',
                'middle_name' => 'E',
                'last_name' => 'Tenasas',
                'role' => 'Vice-President for Academic Services',
                'gender' => 'Female',
                'email' => 'vpas@lnu.edu.ph',
                'telephone' => '+63 53 321 - 8656',
            ],
            [
                'image' => 'Mazo, Generoso N.jpg',
                'title' => 'Dr.',
                'first_name' => 'Generoso',
                'middle_name' => 'N',
                'last_name' => 'Mazo',
                'gender' => 'Male',
                'role' => 'Vice-President for Administration and Finance',
                'email' => 'vpaf@lnu.edu.ph',
                'telephone' => '+63 53 832 - 3133',
            ],
            [
                'image' => 'Caluza, Las Johansen.jpg',
                'title' => 'Dr. ',
                'first_name' => 'Las Johansen',
                'middle_name' => 'B',
                'last_name' => 'Caluza',
                'role' => 'Vice-President for Research and Extension',
                'gender' => 'Male',
                'telephone' => '+63 53 832 - 3169',
            ],
            [
                'image' => 'Lajara, Cleofe.jpg',
                'title' => 'Dr.',
                'first_name' => 'Cleofe',
                'middle_name' => 'L',
                'last_name' => 'Lajara',
                'role' => 'Vice-President for Student Development and Auxillary Services',
                'gender' => 'Female',
                'email' => 'vpsdas@lnu.edu.ph',
                'telephone' => '+63 53 888 - 0929',
            ],
            [
                'image' => 'Fabian, Lina.jpg',
                'title' => 'Dr.',
                'first_name' => 'Lina',
                'middle_name' => 'G',
                'last_name' => 'Fabian',
                'role' => 'Dean, College of Education',
                'gender' => 'Female',
                'telephone' => '+ 63 53 832 - 3205',
                'email' => 'coeoffice@lnu.edu.ph',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Gil Nicetas',
                'middle_name' => 'B',
                'last_name' => 'Villarino',
                'role' => 'Dean, College of Arts and Science',
                'gender' => 'Male',
                'email' => 'lnucas2014@gmail.com',
                'telephone' => '+ 63 53 832 - 3140',
            ],
            [
                'image' => 'Faller, Solomon.jpg',
                'title' => 'Dr.',
                'first_name' => 'Solomon',
                'middle_name' => 'D',
                'last_name' => 'Faller Jr.',
                'role' => 'Dean, College of Management and Entrepreneurship',
                'gender' => 'Male',
                'email' => 'cme@lnu.edu.ph',
                'telephone' => '+ 63 53 832 - 3149'
            ],
            [
                'image' => 'Pelingon, Josephine.jpg',
                'title' => 'Dr.',
                'first_name' => 'Josephine',
                'middle_name' => 'C',
                'last_name' => 'Pelingon',
                'role' => 'Dean, Graduate School',
                'gender' => 'Female',
                'email' => 'gradschool@lnu.edu.ph',
                'telephone' => '+63 53 832 - 3163',
            ],
            [
                'image' => 'Garnace, Reynaldo.jpg',
                'title' => 'Dr.',
                'first_name' => 'Reynaldo',
                'middle_name' => 'B',
                'last_name' => 'Garnace',
                'role' => 'Chief Administrative Officer - Administration',
                'gender' => 'Male',
                'telephone' => '+ 63 53 888 - 0929',
                'email' => 'reynaldo.garnace@lnu.edu.ph',
            ],
            [
                'image' => 'Chato, Josisa.jpg',
                'title' => 'Ms.',
                'first_name' => 'Josisa',
                'middle_name' => 'R',
                'last_name' => 'Chato',
                'role' => 'Chief Administrative Officer - Finance',
                'gender' => 'Female',
                'email' => 'josisachato@lnu.edu.ph',
                'telephone' => '+63 53 832 - 3179',
            ],
        ];

        foreach($data as $schooloff){
            SchoolOfficials::create($schooloff);
        }
    }
}
