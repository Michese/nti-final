<?php

namespace App\Imports;

use App\Models\Cargo;
use App\Models\Cell;
use App\Models\EmployeeWarehouse;
use App\Models\Nomenclature;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Throwable;

class WarehouseImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row[0] === 'Итого') {
                break;
            }

            $titleWarehouse = $row[6];
            $warehouse = Warehouse::where('title', '=', $titleWarehouse)->first();
            if ($warehouse) {
                continue;
            }

            $warehouse = Warehouse::create([
                'title' => $titleWarehouse
            ]);

            $user = User::create([
                "name" => "Warehouseman " . $titleWarehouse,
                "code" => \Str::upper(\Str::random(11)),
                "email" => "warehouseman" . random_int(0, 10000) . "@admin.com",
                "phone" => random_int(80000000000, 89999999999),
                "password" => \Hash::make("1234"),
                "role_id" => 5,
                "email_verified_at" => now()
            ]);

            EmployeeWarehouse::create([
                'user_id' => $user->id,
                'warehouse_id' => $warehouse->warehouse_id
            ]);
        }
    }
}
