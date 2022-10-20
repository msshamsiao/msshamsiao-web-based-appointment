<?php

use Illuminate\Database\Seeder;
use App\Employee;
class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'lawyer_name' => 'John Doe Smith',
            'email' => 'johndoe@email.com',
            'phone' => '09123456789'
        ]);

        Employee::create([
            'lawyer_name' => 'Sarah Jane Doe',
            'email' => 'sarahjane@email.com',
            'phone' => '09123456789'
        ]);

        Employee::create([
            'lawyer_name' => 'Elise Jacob',
            'email' => 'elisejacob@email.com',
            'phone' => '09123456789'
        ]);
    }
}
