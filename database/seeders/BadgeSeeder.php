<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('badges')->insert([
            [
                "name" => "Beginner",
                "requirement" => 50
            ],
            [
                "name" => "Top-fan",
                "requirement" => 2500
            ],
            [
                "name" => "Super-fan",
                "requirement" => 5000
            ]
        ]);
    }
}