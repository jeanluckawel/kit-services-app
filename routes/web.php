<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeExport;
use App\Http\Controllers\EmployeeImportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerceptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'can:dashboard'])->name('dashboard');

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employees
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

    Route::get('employee/create', [EmployeeController::class,'create'])
        ->name('employee.create')->middleware('can:employee_create');

    Route::post('employee/store', [EmployeeController::class,'store'])
        ->name('employee.store')->middleware('can:employee_store');

    Route::get('employee/list', [EmployeeController::class,'list'])
        ->name('employee.list')->middleware('can:employee_list');

    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])
        ->name('employee.edit')->middleware('can:employee_edit');

    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
        ->name('employee.update')->middleware('can:employee_edit');

    Route::patch('/employees/{employee}/disable', [EmployeeController::class, 'disable'])
        ->name('employee.disable')->middleware('can:employee_disable');

    Route::get('/employees/{employee}/view', [EmployeeController::class, 'show'])
        ->name('employee.view')->middleware('can:employee_view');

    Route::get('/employee/import', [EmployeeImportController::class, 'show'])
        ->name('employee.import.show')->middleware('can:employee_import');

    Route::post('/employee/import', [EmployeeImportController::class, 'store'])
        ->name('employee.import.store')->middleware('can:employee_import');

    Route::get('/employee/export', [EmployeeExport::class, 'show'])
        ->name('employee.export.show')->middleware('can:employee_export');

    Route::get('/employee/export/download', [EmployeeExport::class, 'export'])
        ->name('employee.export')->middleware('can:employee_export');

    Route::get('/employees/search', [EmployeeController::class,'search'])
        ->name('employee.search')->middleware('can:employee_search');

    Route::get('/employees/cdd', [EmployeeController::class,'cdd'])
        ->name('employee.cdd')->middleware('can:employee_cdd');

    Route::get('/employees/cdi', [EmployeeController::class,'cdi'])
        ->name('employee.cdi')->middleware('can:employee_cdi');

    Route::get('/employees/{id}/fin-contrat', [EmployeeController::class, 'finContrat'])
        ->name('employee.fin.contract')->middleware('can:employee_contract_end');

    Route::get('/employees/{id}/certificat', [EmployeeController::class, 'certificat'])
        ->name('employee.certificat')->middleware('can:employee_certificate');
});

// Customers
Route::middleware(['auth','verified'])->prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])
        ->name('customer.index')->middleware('can:customer_list');

    Route::get('/create', [CustomerController::class, 'create'])
        ->name('customer.create')->middleware('can:customer_create');

    Route::post('/store', [CustomerController::class, 'store'])
        ->name('customer.store')->middleware('can:customer_store');

    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])
        ->name('customer.edit')->middleware('can:customer_edit');

    Route::put('/{customer}', [CustomerController::class, 'update'])
        ->name('customer.update')->middleware('can:customer_edit');

    Route::delete('/{customer}', [CustomerController::class, 'destroy'])
        ->name('customer.destroy')->middleware('can:customer_delete');

    Route::get('/search', [CustomerController::class, 'search'])
        ->name('customer.search')->middleware('can:customer_search');
});

// Invoices
Route::middleware(['auth','verified'])->group(function () {
    Route::get('invoices/statement', [InvoiceController::class, 'statement'])
        ->name('invoice.statement')->middleware('can:invoice_statement');

    Route::get('/customers/{customer}/invoices/create', [InvoiceController::class, 'create'])
        ->name('invoices.create')->middleware('can:invoice_create');

    Route::post('/customers/{customer}/invoices', [InvoiceController::class, 'store'])
        ->name('invoices.store')->middleware('can:invoice_store');

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])
        ->name('invoices.show')->middleware('can:invoice_view');

    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])
        ->name('invoices.edit')->middleware('can:invoice_edit');

    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])
        ->name('invoices.update')->middleware('can:invoice_edit');

    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])
        ->name('invoices.destroy')->middleware('can:invoice_delete');

    Route::get('invoices/number/{numero}', [InvoiceController::class,'showByNumber'])
        ->name('invoices.showByNumber')->middleware('can:invoice_search_number');
});

// Users
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index')->middleware('can:user_list');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create')->middleware('can:user_create');

    Route::post('/users/store', [UserController::class, 'store'])
        ->name('users.store')->middleware('can:user_store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit')->middleware('can:user_edit');

    Route::put('/users/{user}/update', [UserController::class, 'update'])
        ->name('users.update')->middleware('can:user_edit');

    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])
        ->name('users.destroy')->middleware('can:user_delete');

    Route::get('users/search', [UserController::class, 'search'])
        ->name('users.search')->middleware('can:user_search');

    Route::get('/users/{user}/permissions', [UserController::class, 'editPermissions'])
        ->name('users.editPermissions')->middleware('can:user_update_permissions');

    Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
        ->name('users.updatePermissions')->middleware('can:user_update_permissions');
});

// Roles
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])
        ->name('roles.index')->middleware('can:role_list');

    Route::get('/roles/create', [RoleController::class, 'create'])
        ->name('roles.create')->middleware('can:role_create');

    Route::post('/roles', [RoleController::class, 'store'])
        ->name('roles.store')->middleware('can:role_store');

    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('roles.edit')->middleware('can:role_edit');

    Route::put('/roles/{role}', [RoleController::class, 'update'])
        ->name('roles.update')->middleware('can:role_edit');

    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
        ->name('roles.destroy')->middleware('can:role_delete');
});

// Language switch
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'fr'])) {
        abort(404);
    }
    Session::put('locale', $locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('lang.switch')->middleware('can:language_switch');

// Payroll
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/payrolls', [PayrollController::class,'index'])
        ->name('payroll.index')->middleware('can:payroll_list');

    Route::get('/payrolls/search', [PayrollController::class,'search'])
        ->name('payroll.search')->middleware('can:payroll_search');

    Route::get('/employees/{employee}/payroll/create', [PayrollController::class, 'create'])
        ->name('payroll.create')->middleware('can:payroll_create');

    Route::post('/employees/{employee}/payroll', [PayrollController::class, 'store'])
        ->name('payroll.store')->middleware('can:payroll_store');

    Route::get('/employees/{employee}/payroll/edit', [PayrollController::class, 'edit'])
        ->name('payroll.edit')->middleware('can:payroll_edit');

    Route::get('payroll/history', [PayrollController::class, 'history'])
        ->name('payroll.history')->middleware('can:payroll_history');

    Route::get('/payroll/{employee}/{payroll}', [PayrollController::class, 'show'])
        ->name('payroll.show')->middleware('can:payroll_view');

    Route::get('/payroll/export', [PayrollController::class, 'export'])
        ->name('payroll.export')->middleware('can:payroll_export');

    Route::get('/payroll/view', [PayrollController::class, 'exportview'])
        ->name('payroll.exportView')->middleware('can:payroll_export_view');




    Route::get('/expense-types', [ExpenseTypeController::class,'index'])->name('expense-types.index');
    Route::get('/expense-types/create', [ExpenseTypeController::class,'create'])->name('expense-types.create');
    Route::post('/expense-types/store', [ExpenseTypeController::class,'store'])->name('expense-types.store');
    Route::get('/expense-types/{id}/edit', [ExpenseTypeController::class,'edit'])->name('expense-types.edit');
    Route::put('/expense-types/{id}', [ExpenseTypeController::class,'update'])->name('expense-types.update');
    Route::delete('/expense-types/{id}', [ExpenseTypeController::class,'destroy'])->name('expense-types.destroy');

    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');


// AJAX search
    Route::get('/expense-types/search', [ExpenseTypeController::class,'search'])->name('expense-types.search');
    Route::get('/expenses/history', [ExpenseController::class,'history'])->name('expenses.history');
    Route::get('/expenses/bon/{expense}', [ExpenseController::class, 'bon'])->name('expenses.bon');


    Route::prefix('perceptions')->group(function() {

        Route::get('/', [PerceptionController::class, 'index'])->name('perceptions.index')->middleware('can:perception_list');

        Route::get('/history', [PerceptionController::class, 'history'])->name('perceptions.history');
        Route::get('/create', [PerceptionController::class, 'create'])->name('perceptions.create');
        Route::post('/store', [PerceptionController::class, 'store'])->name('perceptions.store');
        Route::get('/search', [PerceptionController::class, 'search'])->name('perceptions.search');
        Route::delete('/{perception}', [PerceptionController::class, 'destroy'])->name('perceptions.destroy');

    });



    Route::prefix('organization')->group(function () {
        Route::get('/', [\App\Http\Controllers\OrgController::class, 'index'])->name('org.index');
        Route::get('/create', [OrgController::class, 'create'])->name('org.create');
        Route::post('/store', [OrgController::class, 'store'])->name('org.store');
    });


    Route::get('/get-sections/{department}', [EmployeeController::class, 'getSections']);
    Route::get('/get-job-titles/{section}', [EmployeeController::class, 'getJobTitles']);


});

require __DIR__.'/auth.php';
