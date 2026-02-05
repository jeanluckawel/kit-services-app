<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeExport extends Controller
{
    //
    public function show()
    {

        return view('Employee.export');

    }

    public function export( Request $request)
    {
        return Excel::download(
            new EmployeesExport($request->only(['gender','contract_type'])),
            'employees.xlsx'
        );

    }
}
