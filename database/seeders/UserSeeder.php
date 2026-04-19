<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['employee_id' => 'EMP001', 'name' => 'Maria Santos', 'email' => 'maria@dssm.local', 'position' => 'Cashier'],
            ['employee_id' => 'EMP002', 'name' => 'John Rivera', 'email' => 'john@dssm.local', 'position' => 'Cashier'],
            ['employee_id' => 'EMP003', 'name' => 'Ana Garcia', 'email' => 'ana@dssm.local', 'position' => 'Manager'],
            ['employee_id' => 'EMP004', 'name' => 'Carlos Mendoza', 'email' => 'carlos@dssm.local', 'position' => 'Stock Keeper'],
        ];

        foreach ($employees as $emp) {
            User::create([
                'employee_id' => $emp['employee_id'],
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('password123'),
                'position' => $emp['position'],
                'is_active' => true,
            ]);
        }
    }
}