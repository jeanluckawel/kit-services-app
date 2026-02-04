@extends('layoutsddd.app')

@section('title', 'Create employee - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <!-- Employee List Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Employee List</h3>

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
                    <button type="button"
                            class="btn btn-tool"
                            title="Add new employee"
                            style="background:#fff; color:#FF6600; width:40px; height:40px; border-radius:4px;">
                        <a href="{{ route('employee.create') }}"
                           class="text-decoration-none"
                           style="color:#FF6600; font-size: 20px">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </button>
                @endcan
            </div>
        </div>

        <div class="card-body">


            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchEmployee" class="form-control" placeholder="Search by Employee and full name">
                </div>
            </div>


            <div id="employeeContent">
                @include('Employee.partials.search-result', ['employees' => $employees])
            </div>

        </div>

    </div>

    @include('Employee.Modal.disable')

@endsection

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{--<script>--}}
{{--    $(document).ready(function() {--}}

{{--        // Fonction pour charger les employés (tableau + pagination)--}}
{{--        function fetchEmployees(url = "{{ route('employee.search') }}") {--}}
{{--            let search = $('#searchEmployee').val();--}}
{{--            $.ajax({--}}
{{--                url: url,--}}
{{--                type: 'GET',--}}
{{--                data: { search: search },--}}
{{--                success: function(data) {--}}
{{--                    $('#employeeContent').html(data); // Remplace le tableau + pagination--}}
{{--                },--}}
{{--                error: function() {--}}
{{--                    alert("Erreur lors du chargement des employés.");--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        // Recherche AJAX--}}
{{--        $('#searchEmployee').on('keyup', function() {--}}
{{--            fetchEmployees();--}}
{{--        });--}}

{{--        // Pagination AJAX--}}
{{--        $(document).on('click', '.pagination a', function(e) {--}}
{{--            e.preventDefault();--}}
{{--            let url = $(this).attr('href');--}}
{{--            fetchEmployees(url);--}}
{{--            window.history.pushState("", "", url); // met à jour l'URL--}}
{{--        });--}}

{{--        @include('components.alerts')--}}

{{--    }); // <- ce `});` doit rester pour fermer document.ready--}}
{{--</script>--}}

