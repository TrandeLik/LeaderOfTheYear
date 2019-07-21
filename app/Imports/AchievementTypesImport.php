<?php

namespace App\Imports;

use App\AchievementType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
            'category'     => $row['category'],
            'type'    => $row['type'], 
            'stage'    => $row['stage'], 
            'result'    => $row['result'], 
            'score'    => $row['score'], 
        ]);
    }
}
