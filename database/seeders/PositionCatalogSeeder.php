<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('position_catalog')->insert([
            'acronym' => 'P',
            'description' => 'Pitcher',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'C',
            'description' => 'Catcher',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => '1B',
            'description' => 'First Base',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => '2B',
            'description' => 'Second Base',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => '3B',
            'description' => 'Third Base',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'SS',
            'description' => 'Short Stop',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'LF',
            'description' => 'Left Field',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'CF',
            'description' => 'Center Field',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'RF',
            'description' => 'Right Field',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'SF',
            'description' => 'Short Fielder',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'ST',
            'description' => 'Sustituto',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'DP',
            'description' => 'Designated Player',
        ]);
        
        DB::table('position_catalog')->insert([
            'acronym' => 'F',
            'description' => 'Flex',
        ]);

    }
}
