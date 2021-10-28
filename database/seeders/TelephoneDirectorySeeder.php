<?php

namespace Database\Seeders;

use App\Models\TelephoneDirectory;
use Illuminate\Database\Seeder;

class TelephoneDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tels = [
            [
                'name' => 'Office of the President',
                'tel_num' => '832 - 3205'
            ],
            [
                'name' => 'VP for Administration and Finance',
                'tel_num' => '832 - 3133'
            ],
            [
                'name' => 'VP for Research and Extension',
                'tel_num' => '832 - 3169'
            ],
            [
                'name' => 'Dean, COE',
                'tel_num' => '832 - 3095'
            ],
            [
                'name' => 'Dean, CAS',
                'tel_num' => '832 - 3140'
            ],
            [
                'name' => 'Dean, CME',
                'tel_num' => '832 - 3149'
            ],
            [
                'name' => 'Dean, COE',
                'tel_num' => '832 - 3205'
            ],
            [
                'name' => 'Dean, Graduate School',
                'tel_num' => '832 - 3163'
            ],
            [
                'name' => 'Dean, Student Affairs',
                'tel_num' => '832 - 3116'
            ],
            [
                'name' => 'MIS',
                'tel_num' => '832 - 3204'
            ],
            [
                'name' => 'COA',
                'tel_num' => '832 - 3118'
            ],
            [
                'name' => 'Cashier',
                'tel_num' => '832 - 3134'
            ],
            [
                'name' => 'Budget and Planning',
                'tel_num' => '832 - 3203'
            ],
            [
                'name' => 'Accounting',
                'tel_num' => '832 - 3208'
            ],
            [
                'name' => 'Clinic',
                'tel_num' => '832 - 3135'
            ],
            [
                'name' => 'Registrar',
                'tel_num' => '832 - 3180'
            ],
            [
                'name' => 'LNU House',
                'tel_num' => '832 - 3224'
            ],
            [
                'name' => 'Library',
                'tel_num' => '832 - 2748'
            ],
            [
                'name' => 'BAC Office',
                'tel_num' => '832 - 3179'
            ],
            [
                'name' => 'Chief Administrative Office',
                'tel_num' => '832 - 3217'
            ],
            [
                'name' => 'HRMO',
                'tel_num' => '832 - 3137'
            ],
        ];
        
        foreach($tels as $tel){
            TelephoneDirectory::create($tel);
        }
    }
}
