<?php

use App\Messages;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'sender'        =>      1,
            'recipient'     =>      1,
            'subject'       =>      'Welcome to the Accounting System!',
            'message'       =>      'Welcome to the Accounting System for A-1 Driving School.
<br /><br />
This system is part of the requirements for completing a Bachelor\'s Degree in Information Technology at the University of the East, College of Computer Studies and Systems.'
        ];
        $msg = new Messages;
        foreach ($data as $column => $value) {
            $msg->$column = $value;
        }
        $msg->save();
    }
}
