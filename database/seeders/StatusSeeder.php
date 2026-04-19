<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Available', 'description' => 'Item is available for sale'],
            ['name' => 'Reserved', 'description' => 'Item is reserved for a customer'],
            ['name' => 'Damaged', 'description' => 'Item is damaged and cannot be sold'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}