<?php

namespace Database\Seeders;

use App\Models\AdminAccount;
use App\Models\AdminAccountInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_info = AdminAccountInfo::create([
            'first_name' => 'LNU',
            'middle_name' => '',
            'last_name' => 'MIS',
            'gender' => 'Male',
            'contact_number' => '09123456789',
        ]);

        AdminAccount::create([
            'email' => 'mis@lnu.edu.ph',
            'password' => Hash::make('123123'),
            'admin_account_info_id' => $account_info->id
        ]);

        // $account_info_gen = AdminAccountInfo::create([
        //     'first_name' => 'Genreve',
        //     'middle_name' => 'Peque',
        //     'last_name' => 'Fernandez',
        //     'gender' => 'Female',
        //     'contact_number' => '09132456789',
        // ]);

        // AdminAccount::create([
        //     'email' => 'genrevepequefernandez@gmail.com',
        //     'password' => Hash::make('123123'),
        //     'admin_account_info_id' => $account_info_gen->id
        // ]);

        // $account_info_tulawan = AdminAccountInfo::create([
        //     'first_name' => 'Ezikiel',
        //     'middle_name' => 'Pura',
        //     'last_name' => 'Tulawan',
        //     'gender' => 'Male',
        //     'contact_number' => '09132456789',
        // ]);

        // AdminAccount::create([
        //     'email' => 'ezikielpuratulawan@gmail.com',
        //     'password' => Hash::make('123123'),
        //     'admin_account_info_id' => $account_info_tulawan->id
        // ]);
    }
}
