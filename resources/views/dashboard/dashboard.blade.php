@extends('layoutsddd.app')

@section('title', 'Dashboard - KIT SERVICES')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">

            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>

            <div class="col-sm-6">
                <h3 class="mb-0">
                    Hi, Welcome {{ auth()->user()->name }}
                </h3>
            </div>

        </div>
    </div>



{{--    <div class="app-content">--}}

{{--        <div class="container-fluid">--}}
{{--            <!-- Info boxes -->--}}
{{--            <div class="row">--}}

{{--                <!-- /.col -->--}}
{{--                <div class="col-12 col-sm-6 col-md-3">--}}
{{--                    <div class="info-box">--}}
{{--                  <span class="info-box-icon text-bg-warning shadow-sm">--}}
{{--                    <i class="bi bi-people-fill"></i>--}}
{{--                  </span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text">Employee{{ $employeeCount > 1 ? 's' : '' }}  </span>--}}
{{--                            <span class="info-box-number"> {{ number_format((int) $employeeCount) ?? 'N/A' }}</span>--}}
{{--                        </div>--}}
{{--                        <!-- /.info-box-content -->--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box -->--}}
{{--                </div>--}}
{{--                <!-- /.col -->--}}

{{--                <div class="col-12 col-sm-6 col-md-3">--}}
{{--                    <div class="info-box">--}}
{{--                  <span class="info-box-icon text-bg-primary shadow-sm">--}}
{{--                    <i class="bi bi-gear-fill"></i>--}}
{{--                  </span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text">CPU Traffic</span>--}}
{{--                            <span class="info-box-number">--}}
{{--                      10--}}
{{--                      <small>%</small>--}}
{{--                    </span>--}}
{{--                        </div>--}}
{{--                        <!-- /.info-box-content -->--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box -->--}}
{{--                </div>--}}
{{--                <!-- /.col -->--}}
{{--                <div class="col-12 col-sm-6 col-md-3">--}}
{{--                    <div class="info-box">--}}
{{--                  <span class="info-box-icon text-bg-danger shadow-sm">--}}
{{--                    <i class="bi bi-hand-thumbs-up-fill"></i>--}}
{{--                  </span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text">Likes</span>--}}
{{--                            <span class="info-box-number">41,410</span>--}}
{{--                        </div>--}}
{{--                        <!-- /.info-box-content -->--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box -->--}}
{{--                </div>--}}
{{--                <!-- /.col -->--}}
{{--                <!-- fix for small devices only -->--}}
{{--                <!-- <div class="clearfix hidden-md-up"></div> -->--}}
{{--                <div class="col-12 col-sm-6 col-md-3">--}}
{{--                    <div class="info-box">--}}
{{--                  <span class="info-box-icon text-bg-success shadow-sm">--}}
{{--                    <i class="bi bi-cart-fill"></i>--}}
{{--                  </span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text">Sales</span>--}}
{{--                            <span class="info-box-number">760</span>--}}
{{--                        </div>--}}
{{--                        <!-- /.info-box-content -->--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box -->--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        <!--end::Container-->--}}
{{--    </div>--}}

    <div class="app-content">
        <div class="container-fluid">


            <div class="row g-3">

                <!-- Employees -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="bi bi-people-fill"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Employees</span>
                            <span class="info-box-number">{{ $employeeCount ?? '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Departments -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon text-bg-primary shadow-sm">
                        <i class="bi bi-building"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Departments</span>
                            <span class="info-box-number">12</span>
                        </div>
                    </div>
                </div>

                <!-- Active Contracts -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon text-bg-danger shadow-sm">
                       <i class="bi bi-wallet2"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Balance CDF</span>
                            <span class="info-box-number">{{ $balanceCDF ?? '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payrolls -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                         <i class="bi bi-currency-dollar"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Balance USD</span>
                            <span class="info-box-number">{{ $balanceUSD ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= ACTION RAPIDES ================= -->


            <div class="row g-3">

                <!-- ACTIONS RAPIDES -->
                <div class="col-12 col-lg-4">
                    <div class="info-box">
            <span class="info-box-icon text-bg-warning shadow-sm">
                <i class="bi bi-receipt"></i>
            </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Invoices</span>
                            <span class="info-box-number">5,200</span>
                        </div>
                    </div>

                    <div class="info-box">
            <span class="info-box-icon text-bg-success shadow-sm">
                <i class="bi bi-cash-stack"></i>
            </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Payrolls</span>
                            <span class="info-box-number">{{ $balanceUSD ?? '0' }}</span>
                        </div>
                    </div>

                    <div class="info-box">
            <span class="info-box-icon text-bg-primary shadow-sm">
                <i class="bi bi-gear-fill"></i>
            </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Configurations</span>
                            <span class="info-box-number">114,381</span>
                        </div>
                    </div>

                    <div class="info-box">
            <span class="info-box-icon text-bg-danger shadow-sm">
                <i class="bi bi-people-fill"></i>
            </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">{{ $user ?? '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- RECENT PRODUCTS -->
                <div class="col-12 col-lg-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Notifications</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="px-2">
                                <!-- ITEM -->
                                <div class="d-flex align-items-center border-top py-2 px-1">
                                    <div class="flex-shrink-0 me-2">
                                        <img src="./assets/img/default-150x150.png" class="img-size-50" alt="">
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#" class="fw-bold">
                                            Create new user
                                            <span class="badge text-bg-warning float-end">$1800</span>
                                        </a>
                                        <div class="text-truncate">Jean Luc Kawel</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="#" class="text-uppercase">View All Products</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
