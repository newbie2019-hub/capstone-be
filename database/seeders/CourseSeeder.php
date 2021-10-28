<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'course_name' => 'Bachelor of Science in Information Technology',
            'course_abbreviation' => 'BSIT',
            'college_id' => '2',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Arts in Communication',
            'course_abbreviation' => 'BACOMM',
            'college_id' => '2',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Science in Social Work',
            'course_abbreviation' => 'BSSW',
            'college_id' => '2',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Elementary Education',
            'course_abbreviation' => 'BEEd',
            'college_id' => '1',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Secondary Education',
            'course_abbreviation' => 'BSEd',
            'college_id' => '1',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Science in Tourism',
            'course_abbreviation' => 'BSTM',
            'college_id' => '3',
        ]);
        Course::create([
            'course_name' => 'Bachelor of Science in Hotel Management',
            'course_abbreviation' => 'BSHM',
            'college_id' => '3',
        ]);
    }
}
