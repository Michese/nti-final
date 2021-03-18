<?php

namespace Database\Seeders;

use App\Imports\CargoImport;
use App\Imports\CargoImport2;
use App\Imports\CargoImport3;
use App\Imports\CellImport;
use App\Imports\NomenclatureImport;
use App\Imports\WarehouseImport;
use App\Models\Nomenclature;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new NomenclatureImport, 'ost1.xlsx');
        Excel::import(new CargoImport, 'ost1.xlsx');
        Excel::import(new WarehouseImport, 'ost1.xlsx');
        Excel::import(new CellImport, 'ost1.xlsx');
    }
}
