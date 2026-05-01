<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            User::create([
                'employee_id' => $employee->id, 
                'name' => "{$employee->fname} {$employee->lname}",
                'email' => strtolower($employee->fname) . '@dssm.local',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]);
        }
    }
}