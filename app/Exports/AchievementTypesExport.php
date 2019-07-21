<?php

namespace App\Exports;

use App\AchievementType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AchievementTypesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AchievementType::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'category',
            'type',
            'stage',
            'result',
            'score',
            'created_at',
            'updated_at',
        ];
    }


}
