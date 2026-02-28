<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Expense;
use App\Models\Notification;
use App\Models\Payroll;
use App\Models\Perception;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class  DashboardController extends Controller
{
    public function index()
    {


        $user = Auth::user();


        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        $employees = Employee::where('status', 1)->get();
        $employeeCount = Employee::where('status', 1)->count();

        $user = User::count();



        $expenseUSD = Expense::where('currency','USD')->sum('amount');
        $expenseCDF = Expense::where('currency','CDF')->sum('amount');

        $perceptionUSD = Perception::where('currency','USD')->sum('amount');
        $perceptionCDF = Perception::where('currency','CDF')->sum('amount');



        $balanceUSD = $perceptionUSD - $expenseUSD;
        $balanceCDF = $perceptionCDF - $expenseCDF;

        return view('dashboard.dashboard', compact(
            'employees',
            'employeeCount',
            'user',
            'balanceUSD',
            'balanceCDF',
            'notifications',
            'unreadCount'
        ));
    }


    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['is_read' => true]);
        }
        return redirect()->back();
    }
}
