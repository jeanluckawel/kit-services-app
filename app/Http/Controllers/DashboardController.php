<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeCount = Schema::hasTable('employees') ? DB::table('employees')->count() : 0;
        $departmentCount = Schema::hasTable('departments') ? DB::table('departments')->count() : 0;
        $activeContractsCount = Schema::hasTable('contracts') ? DB::table('contracts')->count() : 0;
        $payrollCount = Schema::hasTable('payrolls') ? DB::table('payrolls')->count() : 0;
        $invoiceCount = Schema::hasTable('invoices') ? DB::table('invoices')->count() : 0;
        $configurationCount = Schema::hasTable('configurations') ? DB::table('configurations')->count() : 0;
        $usersCount = Schema::hasTable('users') ? DB::table('users')->count() : 0;

        return view('dashboard.dashboard', compact(
            'employeeCount',
            'departmentCount',
            'activeContractsCount',
            'payrollCount',
            'invoiceCount',
            'configurationCount',
            'usersCount'
        ));
    }
}
