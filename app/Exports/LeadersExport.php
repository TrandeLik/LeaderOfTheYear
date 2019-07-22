<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeadersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::all() -> where('role', 'student');
        foreach ($users as $user){
            $user -> score = $user -> confirmedScore();
            $user -> id = $user -> place();
            unset($user['role']);
            unset($user['email']);
            unset($user['email_verified_at']);
            unset($user['password']);
            unset($user['remember_token']);
            unset($user['created_at']);
            unset($user['updated_at']);
        }
        $leaders = $users -> sortByDesc('score');
        return $leaders;
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
