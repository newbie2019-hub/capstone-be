<?php

namespace Database\Seeders;

use App\Models\TaskSchedule;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskSchedule::create(['task' => 'Post Deletion', 'deletion' => '9999']);
    }
}
