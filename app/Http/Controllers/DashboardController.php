<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employees = Employee::where('status', 1)->get();
        $employeeCount = Employee::where('status', 1)->count();

        return view('dashboard.dashboard', compact('employees', 'employeeCount'));

    }
}
