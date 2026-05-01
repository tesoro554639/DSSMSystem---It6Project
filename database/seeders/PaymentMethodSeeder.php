<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'method_name' => 'Cash',
                'description' => null, 
            ],
            [
                'method_name' => 'Card',
                'description' => null, 
            ],
            [
                'method_name' => 'Gcash',
                'description' => null, 
            ],
            [
                'method_name' => 'Mixed',
                'description' => null, 
            ],
            
        ];

        foreach ($methods as $data) {
            PaymentMethod::create($data);
        }
    }
}