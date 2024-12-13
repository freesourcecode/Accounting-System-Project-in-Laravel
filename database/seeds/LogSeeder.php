<?php

use App\Logs;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entry = new Logs;
        $entry->user = 1;
        $entry->action = "Deployed accounting system.";
        $entry->ip = "127.0.0.1";
        $entry->save();
    }
}
