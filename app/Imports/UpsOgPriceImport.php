<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;

class UpsOgPriceImport implements ToCollection, WithHeadingRow, WithValidation
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

            'us' => 'required|numeric|min:0',
            'ca' => 'required|numeric|min:0',
        ];
    }
}
