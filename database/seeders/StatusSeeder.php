<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'Active'],
            ['id' => 2, 'name' => 'Pending'],
            ['id' => 3, 'name' => 'Suspended'],
            ['id' => 4, 'name' => 'Deleted'],
        ]);
    }
}
