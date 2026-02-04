<div class="sidebar-wrapper">
    <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation">

            {{-- ================= DASHBOARD ================= --}}
            @can('dashboard')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer text-primary"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            @endcan


            {{-- ================= EMPLOYEES ================= --}}
            @canany([
                'employee_create',
                'employee_list',
                'employee_import',
                'employee_export',
                'employee_cdd',
                'employee_cdi'
            ])
                <li class="nav-header">Employees</li>

                @can('employee_create')
                    <li class="nav-item">
                        <a href="{{ route('employee.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-person-plus-fill text-success"></i>
                            <p>Add Employee</p>
                        </a>
                    </li>
                @endcan

                @can('employee_list')
                    <li class="nav-item">
                        <a href="{{ route('employee.list') }}" class="nav-link">
                            <i class="nav-icon bi bi-people-fill text-success"></i>
                            <p>Employee List</p>
                        </a>
                    </li>
                @endcan

                @can('employee_import')
                    <li class="nav-item">
                        <a href="{{ route('employee.import.show') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-arrow-up text-success"></i>
                            <p>Import Employees</p>
                        </a>
                    </li>
                @endcan

                @can('employee_export')
                    <li class="nav-item">
                        <a href="{{ route('employee.export.show') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-arrow-down text-success"></i>
                            <p>Export Employees</p>
                        </a>
                    </li>
                @endcan

                @can('employee_cdd')
                    <li class="nav-item">
                        <a href="{{ route('employee.cdd') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-earmark-text text-success"></i>
                            <p>CDD Contracts</p>
                        </a>
                    </li>
                @endcan

                @can('employee_cdi')
                    <li class="nav-item">
                        <a href="{{ route('employee.cdi') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-earmark-check text-success"></i>
                            <p>CDI Contracts</p>
                        </a>
                    </li>
                @endcan
            @endcanany


            {{-- ================= INVOICES ================= --}}
            @canany(['customer_list','invoice_statement','customer_create'])
                <li class="nav-header">Invoices</li>

                @can('customer_list')
                    <li class="nav-item">
                        <a href="{{ route('customer.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-receipt text-info"></i>
                            <p>All Customers</p>
                        </a>
                    </li>
                @endcan

                @can('invoice_statement')
                    <li class="nav-item">
                        <a href="{{ route('invoice.statement') }}" class="nav-link">
                            <i class="nav-icon bi bi-plus-square text-info"></i>
                            <p>All Statements</p>
                        </a>
                    </li>
                @endcan

                @can('customer_create')
                    <li class="nav-item">
                        <a href="{{ route('customer.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-person-plus text-info"></i>
                            <p>Create Customer</p>
                        </a>
                    </li>
                @endcan
            @endcanany


            {{-- ================= PAYROLLS ================= --}}
            @canany(['payroll_list','payroll_history','payroll_export_view'])
                <li class="nav-header">Payrolls</li>

                @can('payroll_list')
                    <li class="nav-item">
                        <a href="{{ route('payroll.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-plus-circle text-warning"></i>
                            <p>Create</p>
                        </a>
                    </li>
                @endcan

                @can('payroll_history')
                    <li class="nav-item">
                        <a href="{{ route('payroll.history') }}" class="nav-link">
                            <i class="nav-icon bi bi-clock-history text-warning"></i>
                            <p>History</p>
                        </a>
                    </li>
                @endcan

                @can('payroll_export_view')
                    <li class="nav-item">
                        <a href="{{ route('payroll.exportView') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-earmark-text text-warning"></i>
                            <p>Report</p>
                        </a>
                    </li>
                @endcan
            @endcanany



            @canany([
           'expense_type',
           'expense_create',
           'expense_list',
           'expense_history',
       ])
                <li class="nav-header">Expenses</li>


                @can('expense_type')
                    <li class="nav-item">
                        <a href="{{ route('expense-types.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-tags text-danger"></i>
                            <p>Expense Types</p>
                        </a>
                    </li>
                @endcan


                @can('expense_create')
                    <li class="nav-item">
                        <a href="{{ route('expense-types.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-plus-circle text-danger"></i>
                            <p>Create Expense</p>
                        </a>
                    </li>
                @endcan


                @can('expense_list')
                    <li class="nav-item">
                        <a href="{{ route('expenses.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-list-ul text-danger"></i>
                            <p>New Expense </p>
                        </a>
                    </li>
                @endcan


                @can('expense_history')
                    <li class="nav-item">
                        <a href="{{ route('expenses.history') }}" class="nav-link">
                            <i class="nav-icon bi bi-clock-history text-danger"></i>
                            <p>Expense History</p>
                        </a>
                    </li>
                @endcan
            @endcanany

                @canany([
                   'perception_create',
                   'perception_history',
                   'perception_list'
                ])

                <li class="nav-header">Perceptions</li>



                @can('perception_create')
                    <li class="nav-item">
                        <a href="{{ route('perceptions.create') }}"  class="nav-link">
                            <i class="nav-icon bi bi-cash-coin" style="color: orangered"></i>
                            <p>Add Perception</p>
                        </a>
                    </li>
                @endcan


                @can('perception_list')
                    <li class="nav-item">
                        <a href="{{ route('perceptions.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-card-list" style="color: orangered"></i>
                            <p>Perception List</p>
                        </a>
                    </li>
                @endcan


{{--                @can('perception_history')--}}
{{--                    <li  class="nav-item">--}}
{{--                        <a href =" {{ route('perceptions.history') }} " class="nav-link">--}}
{{--                            <i class="nav-icon bi bi-clock-history" style="color: orangered"></i>--}}
{{--                            <p>Perception History</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
            @endcanany



            @canany(['user_list','user_create','role_list','role_create'])
                <li class="nav-header">Configuration</li>

                @can('user_list')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-people text-secondary"></i>
                            <p>All Users</p>
                        </a>
                    </li>
                @endcan

                @can('user_create')
                    <li class="nav-item">
                        <a href="{{ route('users.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-person-plus text-secondary"></i>
                            <p>Create User</p>
                        </a>
                    </li>
                @endcan

                @can('role_list')
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-shield-lock text-secondary"></i>
                            <p>All Roles</p>
                        </a>
                    </li>
                @endcan

                @can('role_create')
                    <li class="nav-item">
                        <a href="{{ route('roles.create') }}" class="nav-link">
                            <i class="nav-icon bi bi-file-plus text-secondary"></i>
                            <p>Create Role</p>
                        </a>
                    </li>
                    <br><br><br>
                @endcan
            @endcanany

        </ul>
    </nav>
</div>
