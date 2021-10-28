<?php

namespace Database\Seeders;

use App\Models\DepartmentUser;
use App\Models\OrganizationAccount;
use App\Models\OrganizationUser;
use App\Models\UserAccount;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** USER 1 */
        $userinfo1 = UserInfo::create([
            'first_name' => 'Ezikiel',
            'middle_name' => 'Pura',
            'last_name' => 'Tulawan',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 6,
        ]);

        $user1 = UserAccount::create([
            'user_info_id' => $userinfo1->id,
            'email' => 'ezikielpuratulawan@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user1->id,
            'organization_id' => 1
        ]);

        /** USER 2 */
        $userinfo2 = UserInfo::create([
            'first_name' => 'Danica',
            'middle_name' => 'Fuentes',
            'last_name' => 'Barrientos',
            'gender' => 'Female',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 5,
        ]);

        $user2 = UserAccount::create([
            'user_info_id' => $userinfo2->id,
            'email' => 'averybering@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Pending',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user2->id,
            'organization_id' => 1
        ]);

        /** USER 3 */
        $userinfo3 = UserInfo::create([
            'first_name' => 'Derick Justin',
            'middle_name' => 'Moral',
            'last_name' => 'Durante',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 4,
        ]);

        $user3 = UserAccount::create([
            'user_info_id' => $userinfo3->id,
            'email' => 'derickjustin@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Pending',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user3->id,
            'organization_id' => 1
        ]);

        /** USER 4 */
        $userinfo4 = UserInfo::create([
            'first_name' => 'Melbienri',
            'middle_name' => '',
            'last_name' => 'Gabitan',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 3,
        ]);

        $user4 = UserAccount::create([
            'user_info_id' => $userinfo4->id,
            'email' => 'melbienrigabitan@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user4->id,
            'organization_id' => 1
        ]);

        /** USER 5 */
        $userinfo5 = UserInfo::create([
            'first_name' => 'John Lloyd',
            'middle_name' => '',
            'last_name' => 'Rosanes',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 2,
        ]);

        $user5 = UserAccount::create([
            'user_info_id' => $userinfo5->id,
            'email' => 'jlrosanes@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user5->id,
            'organization_id' => 1
        ]);

        /** USER 6 */
        $userinfo6 = UserInfo::create([
            'first_name' => 'Genreve',
            'middle_name' => 'Peque',
            'last_name' => 'Fernandez',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 1,
        ]);

        $user6 = UserAccount::create([
            'user_info_id' => $userinfo6->id,
            'email' => 'genrevepequefernandez@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user6->id,
            'organization_id' => 1
        ]);

        /** USER 7 */
        $userinfo7 = UserInfo::create([
            'first_name' => 'Cirilo',
            'middle_name' => 'Espinisin',
            'last_name' => 'Bucatcat',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 8,
        ]);

        $user7 = UserAccount::create([
            'user_info_id' => $userinfo7->id,
            'email' => 'cirilobucatcat@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Pending',
            'type' => 'Organization'
        ]);

        OrganizationUser::create([
            'user_account_id' => $user7->id,
            'organization_id' => 1
        ]);

        /** USER 8 */
        $userinfo8 = UserInfo::create([
            'first_name' => 'Rommel',
            'middle_name' => 'L',
            'last_name' => 'Verecio',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 9,
        ]);

        $user8 = UserAccount::create([
            'user_info_id' => $userinfo8->id,
            'email' => 'rommelverecio@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Department'
        ]);

        DepartmentUser::create([
            'user_account_id' => $user8->id,
            'department_id' => 1
        ]);

        /** USER 9 */
        $userinfo9 = UserInfo::create([
            'first_name' => 'Raphy',
            'middle_name' => 'A',
            'last_name' => 'Dalan',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 11,
        ]);

        $user9 = UserAccount::create([
            'user_info_id' => $userinfo9->id,
            'email' => 'raphydalan@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Pending',
            'type' => 'Department'
        ]);

        DepartmentUser::create([
            'user_account_id' => $user9->id,
            'department_id' => 1
        ]);

        /** USER 10 */
        $userinfo10 = UserInfo::create([
            'first_name' => 'Dennis',
            'middle_name' => 'S',
            'last_name' => 'Tibe',
            'gender' => 'Male',
            'contact_number' => '09123456790',
            'org_unit_role_id' => 11,
        ]);

        $userinfo10 = UserAccount::create([
            'user_info_id' => $userinfo10->id,
            'email' => 'dennistibe@gmail.com',
            'password' => Hash::make('123123'),
            'status' => 'Approved',
            'type' => 'Department'
        ]);

        DepartmentUser::create([
            'user_account_id' => $userinfo10->id,
            'department_id' => 1
        ]);

     
    }
}
