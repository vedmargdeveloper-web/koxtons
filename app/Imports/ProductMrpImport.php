<?php

namespace App\Imports;

use App\Model\ProductMrp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;

class ProductMrpImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Skip the header row
    }

    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row[0]) && empty($row[1]) && empty($row[2])) {
            return null;
        }

        return new ProductMrp([
            'model'      => $row[0] ?? null,
            'item_name'  => $row[1] ?? null,
            'qty'        => is_numeric($row[2]) ? $row[2] : null,
            'qty_metric' => $row[3] ?? null,
            'size'       => $row[4] ?? null,
            'code'       => $row[5] ?? null,
            'mfg_date'   => $this->parseDate($row[6] ?? null),
            'mrp'        => $row[7] ?? null,
            'barcode'    => $row[8] ?? null,
            'paper_size' => $row[9] ?? null,
        ]);
    }

    private function parseDate($value)
    {
        try {
            if (!empty($value)) {
                return Carbon::parse($value)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null; // Ignore invalid values
        }
        return null;
    }
}
