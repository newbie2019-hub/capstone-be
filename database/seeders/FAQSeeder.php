<?php

namespace Database\Seeders;

use App\Models\Faqs;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            [
                'question' => 'What is the email address for the university where we can send our queries?',
                'answer' => 'info@lnu.edu.ph',
            ],
            [
                'question' => 'What is the address for the university?',
                'answer' => 'Leyte Normal University, Paterno Street, Tacloban City',
            ],
            [
                'question' => 'What is the official facebook page of the university?',
                'answer' => 'www.facebook.com/lnuofficial',
            ],
            [
                'question' => 'Where can we find scholarship?',
                'answer' => 'You can check the student services for scholarships',
            ],
        ];
        
        foreach($faqs as $faq){
            Faqs::create($faq);
        }
    }
}
