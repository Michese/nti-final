<?php

namespace App\Imports;

use App\Models\Cargo;
use App\Models\Cell;
use App\Models\CellCargo;
use App\Models\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CellImport implements ToCollection, WithStartRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row[0] === 'Итого') {
                break;
            }

            $cellExplode = explode('-', $row[0]);
            $rowCell = $cellExplode[1];
            $columnCell = $cellExplode[2];

            $titleWarehouse = $row[6];
            $warehouse = Warehouse::where('title', '=', $titleWarehouse)->first();

            $cell = Cell::where('warehouse_id', '=', $warehouse->warehouse_id)
                ->where('row', '=', $rowCell)
                ->where('column', '=', $columnCell)->first();

            if ($cell) {
                continue;
            }

            Cell::create([
                'warehouse_id' => $warehouse->warehouse_id,
                'row' => $rowCell,
                'column' => $columnCell,
            ]);
        }

        foreach ($collection as $row) {
            if ($row[0] === 'Итого') {
                break;
            }

            $cellExplode = explode('-', $row[0]);
            $rowCell = $cellExplode[1];
            $columnCell = $cellExplode[2];

            $titleWarehouse = $row[6];
            $warehouse = Warehouse::where('title', '=', $titleWarehouse)->first();

            $cell = Cell::where('warehouse_id', '=', $warehouse->warehouse_id)
                ->where('row', '=', $rowCell)
                ->where('column', '=', $columnCell)->first();

            $barcode = $row[1];
            $cargo = Cargo::where("barcode", '=', $barcode)->first();

            CellCargo::create([
                'cell_id' => $cell->cell_id,
                'cargo_id' => $cargo->cargo_id
            ]);
        }

    }

    public function startRow(): int
    {
        return 2;
    }
}
