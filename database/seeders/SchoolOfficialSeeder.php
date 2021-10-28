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
                'title' => 'Dr.',
                'first_name' => 'Evelyn',
                'middle_name' => 'B',
                'last_name' => 'Aguirre',
                'gender' => 'Female',
                'role' => 'University President',
                'email' => 'president@lnu.edu.ph',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Myrna',
                'middle_name' => 'L',
                'role' => 'Vice-President for Academic Services',
                'last_name' => 'Macalinao',
                'gender' => 'Female',
                'email' => 'vpas@lnu.edu.ph',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Generoso',
                'middle_name' => 'N',
                'last_name' => 'Mazo',
                'gender' => 'Male',
                'role' => 'Vice-President for Administration and Finance',
                'email' => 'vpaf@lnu.edu.ph',
            ],
            [
                'title' => 'Dr. ',
                'first_name' => 'Ma. Victoria',
                'middle_name' => 'D',
                'last_name' => 'Naboya',
                'role' => 'Research and Extension',
                'gender' => 'Female',
                'telephone' => '+63 53 832 - 3169',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Lina',
                'middle_name' => 'G',
                'last_name' => 'Fabian',
                'role' => 'Vice-President for Student Development and Auxillary Services',
                'gender' => 'Female',
                'email' => 'vpsdas@lnu.edu.ph',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Marife',
                'middle_name' => 'N',
                'last_name' => 'Daga',
                'role' => 'Dean, College of Education',
                'gender' => 'Female',
                'email' => '',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Jacqueline',
                'middle_name' => 'I',
                'last_name' => 'Espina',
                'role' => 'Dean, College of Arts and Science',
                'gender' => 'Female',
                'email' => 'lnucas2014@gmail.com',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Ariel',
                'middle_name' => 'B',
                'last_name' => 'Lunzaga',
                'role' => 'Dean, College of Management and Entrepreneurship',
                'gender' => 'Male',
                'email' => 'ablunzaga@lnu.edu.ph',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Ma. Rocini',
                'middle_name' => '',
                'last_name' => 'Tenasas',
                'role' => 'Dean, Graduate School',
                'gender' => 'Female',
                'email' => 'ablunzaga@lnu.edu.ph',
                'telephone' => '+63 53 832 - 3163',
            ],
            [
                'title' => 'Dr.',
                'first_name' => 'Reynaldo',
                'middle_name' => 'B',
                'last_name' => 'Garnace',
                'role' => 'Chief Administrative Officer - Administration',
                'gender' => 'Male',
                'email' => '',
            ],
            [
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
