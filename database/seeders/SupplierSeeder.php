<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Thrift Supply Co.', 'contact_person' => 'John Doe', 'phone' => '0912-345-6789', 'address' => 'Manila, Philippines'],
            ['name' => 'Fashion Wholesale', 'contact_person' => 'Jane Smith', 'phone' => '0918-765-4321', 'address' => 'Quezon City, Philippines'],
            ['name' => 'Bulk Items Inc.', 'contact_person' => 'Mike Wilson', 'phone' => '0922-123-4567', 'address' => 'Cebu City, Philippines'],
            ['name' => 'Garment Direct', 'contact_person' => 'Sarah Lee', 'phone' => '0933-987-6543', 'address' => 'Davao City, Philippines'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}