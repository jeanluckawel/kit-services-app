<?php

namespace App\Exports;

use App\Models\Employee\Children;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChildrenExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Children::whereNull('deleted_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Full Name',
            'Date of Birth',
            'Gender',
            'Created At',
        ];
    }

    public function map($child): array
    {
        return [
            $child->id,
            $child->employee_id,
            $child->full_name,
            $child->date_of_birth,
            $child->gender,
            $child->created_at,
        ];
    }
}
