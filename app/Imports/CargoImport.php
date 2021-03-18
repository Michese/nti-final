<?php

namespace App\Imports;


use App\Models\Cargo;
use App\Models\Nomenclature;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CargoImport implements ToCollection, WithStartRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row[0] === 'Итого') {
                break;
            }

            $barcode = $row[1];
            $weight = $row[8];

            $numberNomenclature = $row[3];
            $nomenclature = Nomenclature::where('number', '=', $numberNomenclature)->first();

            if (!$nomenclature) {
                continue;
            }

            $cargo = Cargo::where("barcode", '=', $barcode)->first();

            if ($cargo) {
                continue;
            }

            Cargo::create([
                "nomenclature_id" => $nomenclature->nomenclature_id,
                "barcode" => $barcode,
                "weight" => $weight
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
