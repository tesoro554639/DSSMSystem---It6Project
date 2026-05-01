<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EmployeeSeeder::class,
            UserSeeder::class,
            PaymentMethodSeeder::class,
            SupplierSeeder::class,
            CategorySeeder::class,
            StatusSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}