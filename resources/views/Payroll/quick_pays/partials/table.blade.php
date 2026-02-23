@extends('layoutsddd.app')

@section('title', 'Employee Payments - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <div class="card-header d-flex align-items-center" style="background-color: #FF6600; color: #fff;">
            <h3 class="mb-0">Employee Payments</h3>
            <div class="ms-auto">
                <a href="#" class="btn btn-light text-orange"><i class="bi bi-plus-lg"></i> New Quick Pay</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchEmployee" class="form-control" placeholder="Search Employee">
                </div>

                <div class="col-md-3">
                    <label for="filterPeriod" class="form-label">Filter by Period</label>
                    <select id="filterPeriod" class="form-select">
                        <option value="">All Periods</option>
                        @foreach([1=>'January',2=>'February',3=>'March',4=>'April',
                                 5=>'May',6=>'June',7=>'July',8=>'August',
                                 9=>'September',10=>'October',11=>'November',12=>'December'] as $num => $month)
                            <option value="{{ $num }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="employeeContent">
                @include('Payroll.quick_pays.partials.table', ['employees' => $employees, 'filterPeriod' => $filterPeriod])
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){

            function fetchEmployees(url = null){
                let query = $('#searchEmployee').val();
                let period = $('#filterPeriod').val();
                url = url || "{{ route('quick-pay.employees.search') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { search: query, period: period },
                    success: function(data){
                        $('#employeeContent').html(data);
                    },
                    error: function(){
                        alert("Error fetching employees");
                    }
                });
            }

            $('#searchEmployee').on('keyup', fetchEmployees);
            $('#filterPeriod').on('change', fetchEmployees);

            // Pagination AJAX
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let url = $(this).attr('href');
                fetchEmployees(url);
                window.history.pushState("", "", url);
            });

        });
    </script>
@endsection
