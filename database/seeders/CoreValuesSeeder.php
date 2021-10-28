<?php

namespace Database\Seeders;

use App\Models\CoreValues;
use Illuminate\Database\Seeder;

class CoreValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $core_value = [
            [
                'core_value' => 'Excellence',
                'description' => 'We persistently pursue success and continuously look for innovative ways to improve our services'
            ],
            [
                'core_value' => 'INTEGRITY',
                'description' => 'We are accountable, honest, trustworthy, respectful, and ethical in our actions.
                                  We uphold a level of independence that assures confidence.'
            ],
            [
                'core_value' => 'SERVICE',
                'description' => 'We serve our internal and external customers with a smile.
                We deliver outstanding service to all, regardless of status, creed, color and race.'
            ],
        ];

        foreach($core_value as $cv){
            CoreValues::create($cv);
        }
    }
}
