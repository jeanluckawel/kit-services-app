@extends('layoutsddd.app')

@section('title', 'Dashboard - KIT SERVICES')

@section('content')

    <div class="app-content">
        <div class="container-fluid">


            <div class="row g-3">


                <!-- Employees -->
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ asset('files/kit services employee.xlsx') }}" download class="text-decoration-none">
                        <div class="info-box">
                        <span class="info-box-icon text-bg-warning shadow-sm">
                            <i class="bi bi-people-fill"></i>
                        </span>
                            <div class="info-box-content">
                                <span class="info-box-text">File</span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>


        </div>
    </div>
@endsection
