<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;

class FedexPriceImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    public $validatedRows = [];

    public function collection(Collection $rows)
    {
        // Data is only stored, not saved
        foreach ($rows as $row) {
            $this->validatedRows[] = $row->toArray();
        }
    }

    public function rules(): array
    {
        return [
            'type'   => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',

            'zone_a' => 'required|numeric|min:0',
            'zone_b' => 'required|numeric|min:0',
            'zone_c' => 'required|numeric|min:0',
            'zone_d' => 'required|numeric|min:0',
            'zone_e' => 'required|numeric|min:0',
            'zone_f' => 'required|numeric|min:0',
            'zone_g' => 'required|numeric|min:0',
            'zone_h' => 'required|numeric|min:0',
            'zone_i' => 'required|numeric|min:0',
            'zone_j' => 'required|numeric|min:0',
            'zone_k' => 'required|numeric|min:0',
            'zone_l' => 'required|numeric|min:0',
            'zone_m' => 'required|numeric|min:0',
            'zone_n' => 'required|numeric|min:0',
        ];
    }
}
