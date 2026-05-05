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
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}