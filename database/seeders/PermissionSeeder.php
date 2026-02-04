<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [

            'dashboard',

// Employees
            'employee_create',
            'employee_store',
            'employee_list',
            'employee_view',
            'employee_edit',
            'employee_disable',
            'employee_import',
            'employee_export',
            'employee_search',
            'employee_cdd',
            'employee_cdi',
            'employee_contract_end',
            'employee_certificate',
            'employee_address',
            'employee_photo',
            'employee_company',
            'employee_children',
            'employee_dependants',
            'employee_emergency',
            'employee_salary',



// Customers
            'customer_list',
            'customer_create',
            'customer_store',
            'customer_edit',
            'customer_delete',
            'customer_search',

// Invoices
            'invoice_statement',
            'invoice_create',
            'invoice_store',
            'invoice_view',
            'invoice_edit',
            'invoice_delete',
            'invoice_search_number',

// Users
            'user_list',
            'user_create',
            'user_store',
            'user_edit',
            'user_delete',
            'user_search',
            'user_update_permissions',

// Roles
            'role_list',
            'role_create',
            'role_store',
            'role_edit',
            'role_delete',

// Payroll
            'payroll_list',
            'payroll_search',
            'payroll_create',
            'payroll_store',
            'payroll_edit',
            'payroll_view',
            'payroll_history',
            'payroll_export',
            'payroll_export_view',
// expense
            'expense_type',
            'expense_create',
            'expense_list',
            'expense_history',

//  Perception
            'perception_create',
            'perception_history',
            'perception_list',

// Language
            'language_switch',

        ];



        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }


        $roles = [
            'admin' => Permission::all()->pluck('name')->toArray(),
            'drh' => [
                'language_switch'

            ],
            'clerk' => [
                'language_switch',
            ],
            'none' => [],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($perms);
        }


        $users = [
            [
                'name' => 'Admin ',
                'email' => 'admin@kit-services.org',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'DRH ',
                'email' => 'drh@kit-services.org',
                'password' => bcrypt('password'),
                'role' => 'drh',
            ],
            [
                'name' => 'Clerk ',
                'email' => 'clerk@kit-services.org',
                'password' => bcrypt('password'),
                'role' => 'clerk',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
