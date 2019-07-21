<?php

namespace App\Imports;

use App\AchievementType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class AchievementTypesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AchievementType([
            'category'     => $row['Категория'],
            'type'    => $row['Тип'], 
            'stage'    => $row['Этап'], 
            'result'    => $row['Результат'], 
            'score'    => $row['Баллы'], 
        ]);
    }
}
