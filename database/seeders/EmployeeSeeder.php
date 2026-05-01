<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'fname' => 'Recmar',
                'mname' => null,
                'lname' => 'Santos',
                'phone' => '09123456789',
                'position' => 'Cashier'
            ],
            [
                'fname' => 'John',
                'mname' => null,
                'lname' => 'Rivera',
                'phone' => '09223334444',
                'position' => 'Cashier'
            ],
            [
                'fname' => 'Ana',
                'mname' => null,
                'lname' => 'Garcia',
                'phone' => '09334445555',
                'position' => 'Manager'
            ],
            [
                'fname' => 'Carlos',
                'mname' => null,
                'lname' => 'Mendoza',
                'phone' => '09445556666',
                'position' => 'Stock Keeper'
            ],
        ];

        foreach ($employees as $data) {
            Employee::create($data);
        }
    }
}