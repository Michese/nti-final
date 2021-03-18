<?php

namespace App\Imports;

use App\Models\Nomenclature;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NomenclatureImport implements ToCollection, WithStartRow
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

            $numberNomenclature = $row[3];
            $nomenclature = Nomenclature::where('number', '=', $numberNomenclature)->first();

            if ($nomenclature) {
                continue;
            }

            Nomenclature::create([
                'number' => $numberNomenclature,
                'body' => $row[4]
            ]);
        }
    }
}
