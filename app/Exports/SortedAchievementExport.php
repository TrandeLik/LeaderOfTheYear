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

    public function __construct(array $achievements,$filters)
    {
        $this->achievements = $achievements;
        $this->filters = $filters;
    }

    public function array(): array
    {
        $filteredAchievements = [];
        foreach($this->achievements as $achievement){
            foreach($this->filters as $column=>$value){
                if (($value['value']!=1) and (isset($achievement[$column]))){
                    unset($achievement[$column]);
                }
            }
            unset($achievement["score"]);
            array_push($filteredAchievements,$achievement);
        }
        return $filteredAchievements;
    }

    public function headings(): array
    {
        $headings = [];
        $achievements = $this->achievements;
        $achievement = array_shift($achievements);
        foreach ($this->filters as $column=>$value){
            if (($value['value']) and (isset($achievement[$column]))){
                array_push($headings,$value['text']);
            }
        }
        return $headings;
    }
}
