<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SortedAchievementExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $achievements;

    public function __construct(array $achievements)
    {
        $this->achievements = $achievements;
    }

    public function array(): array
    {
        return $this->achievements;
    }

    public function headings(): array
    {
        return [
            'ФИО',
            'Класс',
            'Категория',
            'Тип',
            'Название',
            'Предмет',
            'Баллы',
        ];
    }
}
