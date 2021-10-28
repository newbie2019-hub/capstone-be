<?php

namespace Database\Seeders;

use App\Models\Objective;
use Illuminate\Database\Seeder;

class ObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Objective::create([
            'objective' => 'Provide pre-service training through supervised clinical and field based practicum experience',
            'college_id' => '4',
        ]);
        Objective::create([
            'objective' => 'Offer relevant and enriched teacher education curriculum',
            'college_id' => '4',
        ]);
        Objective::create([
            'objective' => 'Try out innovations and other alternative modes of instructional delivery',
            'college_id' => '4',
        ]);
        Objective::create([
            'objective' => 'Conduct researches and use findings to improve instructional procedures and practices',
            'college_id' => '4',
        ]);
        Objective::create([
            'objective' => 'Get actively involved in community extension service and other external linkages',
            'college_id' => '4',
        ]);
        
    }
}
