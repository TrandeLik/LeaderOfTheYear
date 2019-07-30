<?php

namespace App\Exports;

use App\AchievementType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AchievementTypesExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return AchievementType::select('category','type','stage','result','score');
    }

    public function headings(): array
    {
        return [
            'Категория',
            'Тип',
            'Этап',
            'Результат',
            'Баллы',
        ];
    }


}
