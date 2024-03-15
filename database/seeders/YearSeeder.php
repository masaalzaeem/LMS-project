<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Year;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::create([
            'year' => '1st',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '2nd',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '3rd',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '4th',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '5th',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '6th',
            'stage_id' => '1'
        ]);
        Year::create([
            'year' => '1st',
            'stage_id' => '2'
        ]);
        Year::create([
            'year' => '2nd',
            'stage_id' => '2'
        ]);
        Year::create([
            'year' => '3rd',
            'stage_id' => '2'
        ]);
        Year::create([
            'year' => '1st',
            'stage_id' => '3'
        ]);
        Year::create([
            'year' => '2nd',
            'stage_id' => '3'
        ]);
        Year::create([
            'year' => '3rd',
            'stage_id' => '3'
        ]);
        Year::create([
            'year' => '1st',
            'stage_id' => '4'
        ]);
        Year::create([
            'year' => '2nd',
            'stage_id' => '4'
        ]);
        Year::create([
            'year' => '3rd',
            'stage_id' => '4'
        ]);
    }
}
