<?php

use App\Branches;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = new Branches;
        $branch->name = "Mandaluyong";
        $branch->address = "JRU Mandaluyong";
        $branch->save();
    }
}
