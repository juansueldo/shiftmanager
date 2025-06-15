<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero se ejecuta el StatusSeeder ya que otros modelos pueden depender de los estados
        $this->call(StatusSeeder::class);
        
        // Luego se ejecuta el RolesTableSeeder
        $this->call(RolesTableSeeder::class);
        
        // Aquí puedes agregar más seeders en el orden que necesites
    }
} 