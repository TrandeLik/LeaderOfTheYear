<?php

namespace App\Exports;

use App\AchievementType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AchievementTypesExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            'Категория',
            'Тип',
            'Этап',
            'Результат',
            'Баллы',
            'created_at',
            'updated_at',
        ];
    }


}
