<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;

class UpsPriceImport implements ToCollection, WithHeadingRow, WithValidation
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

            'zone_1' => 'required|numeric|min:0',
            'zone_2' => 'required|numeric|min:0',
            'zone_3' => 'required|numeric|min:0',
            'zone_4' => 'required|numeric|min:0',
            'zone_5' => 'required|numeric|min:0',
            'zone_6' => 'required|numeric|min:0',
            'zone_7' => 'required|numeric|min:0',
            'zone_8' => 'required|numeric|min:0',
            'zone_9' => 'required|numeric|min:0',
            'zone_10' => 'required|numeric|min:0',
            'zone_11' => 'required|numeric|min:0',

            'au' => 'required|numeric|min:0',
            'nz' => 'required|numeric|min:0',
            'ae' => 'required|numeric|min:0',
            'de' => 'required|numeric|min:0',
            'nl' => 'required|numeric|min:0',
            'pl' => 'required|numeric|min:0',
        ];
    }
}
