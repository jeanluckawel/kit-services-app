@extends('layoutsddd.app')

@section('title', 'Employee Payments - KIT SERVICES')

@section('content')
    <div class="card mb-4 m-5">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Employee Payments</h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">
                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan
                    <li class="breadcrumb-item active text-white" aria-current="page">List</li>
                </ol>
            </nav>

            <div class="card-tools ms-3">
                @can('employee_create')
                    <a href="{{ route('quick_pay') }}" class="btn btn-light text-orange">
                        <i class="bi bi-plus-lg"></i> New  Pay
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body">

            <!-- Filters -->
{{--            <div class="row mb-3">--}}
{{--                <div class="col-md-4">--}}
{{--                    <input type="text" id="searchEmployee" class="form-control" placeholder="Search Employee">--}}
{{--                </div>--}}

{{--                <div class="col-md-3">--}}
{{--                    <label for="filterPeriod" class="form-label">Filter by Month</label>--}}
{{--                    <select id="filterPeriod" class="form-select">--}}
{{--                        <option value="">All Months</option>--}}
{{--                        @foreach([--}}
{{--                            1=>'January',2=>'February',3=>'March',4=>'April',--}}
{{--                            5=>'May',6=>'June',7=>'July',8=>'August',--}}
{{--                            9=>'September',10=>'October',11=>'November',12=>'December'--}}
{{--                        ] as $num => $month)--}}
{{--                            <option value="{{ $num }}" {{ $num == now()->month ? 'selected' : '' }}>{{ $month }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="col-md-2">--}}
{{--                    <label for="filterYear" class="form-label">Filter by Year</label>--}}
{{--                    <select id="filterYear" class="form-select">--}}
{{--                        @for($y = now()->year; $y >= now()->year - 5; $y--)--}}
{{--                            <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>--}}
{{--                        @endfor--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Employee Table -->
            <div id="employeeContent">
                @include('Payroll.quick_pays.partials.employee_table', [
                    'paidEmployees' => $paidEmployees,
                    'unpaidEmployees' => $unpaidEmployees
                ])
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function fetchEmployees() {
                let query = $('#searchEmployee').val();
                let period = $('#filterPeriod').val();
                let year = $('#filterYear').val();

                $.ajax({
                    url: "{{ route('quick_pay.list.ajax') }}",
                    type: 'GET',
                    data: { search: query, period: period, year: year },
                    success: function(data) {
                        $('#employeeContent').html(data);
                    },
                    error: function() {
                        alert("Error fetching employees");
                    }
                });
            }


            $('#searchEmployee, #filterPeriod, #filterYear').on('change keyup', fetchEmployees);


            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let url = $(this).attr('href');
                $.get(url, function(data){
                    $('#employeeContent').html(data);
                    window.history.pushState("", "", url);
                });
            });


            fetchEmployees();

        });
    </script>
@endsection
