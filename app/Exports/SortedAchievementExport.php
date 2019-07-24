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
        $this->achievements=[];
        foreach ($achievements as $achievement){
            unset($achievement['id']);
            unset($achievement['created_at']);
            unset($achievement['updated_at']);
            unset($achievement['confirmation']);
            unset($achievement['status']);
            unset($achievement['user_id']);
            unset($achievement['user']);
            array_push($this->achievements,$achievement);
        }
    }

    public function array(): array
    {
        return $this->achievements;
    }

    public function headings(): array
    {
        return [
            'Место',
            'ФИО',
            'Класс',
            'Баллы',
        ];
    }
}
