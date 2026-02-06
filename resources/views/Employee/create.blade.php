@extends('layoutsddd.app')

@section('title', 'Create Employee - KIT SERVICES')

@section('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container .select2-results__option img {
            width: 20px;
            height: 15px;
            margin-right: 8px;
        }

        .select2-container .select2-selection__rendered img {
            width: 20px;
            height: 15px;
            margin-right: 8px;
        }
    </style>


    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Add New Employee</h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">


                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan


                    @can('employee_list')
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee.list') }}" class="text-white">Employee</a>
                        </li>
                    @endcan


                    <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
                </ol>
            </nav>

        </div>

        <!-- Form -->
        <div class="card-body">
            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" autocomplete="kit-services-sarl">
                @csrf

                <!-- Tabs nav -->
                <ul class="nav nav-tabs mb-4" id="employeeTab" role="tablist" style="border-radius:0;">


                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button" role="tab"
                                style="color:#FF6600; font-weight:500; border-radius:0;">
                            <i class="bi bi-person-fill me-1"></i> Personal
                        </button>
                    </li>


                    @can('employee_address')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500; border-radius:0;">
                                <i class="bi bi-geo-alt-fill me-1"></i> Address
                            </button>
                        </li>
                    @endcan


                    @can('employee_photo')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500; border-radius:0;">
                                <i class="bi bi-camera-fill me-1"></i> Photo
                            </button>
                        </li>
                    @endcan


                    @can('employee_company')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company"
                                    type="button" role="tab" style="color:#ff6600; font-weight:500;">
                                <i class="bi bi-briefcase-fill me-1"></i> Company
                            </button>
                        </li>
                    @endcan


                    @can('employee_children')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education"
                                    type="button" role="tab" style="color:#ff6600; font-weight:500;">
                                <i class="bi bi-book-fill me-1"></i> Children
                            </button>
                        </li>
                    @endcan


                    @can('employee_dependants')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dependants-tab" data-bs-toggle="tab" data-bs-target="#dependants"
                                    type="button" role="tab" style="color:#ff6600; font-weight:500;">
                                <i class="bi bi-people-fill me-1"></i> Dependants
                            </button>
                        </li>
                    @endcan


                    @can('employee_emergency')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="emergency-tab" data-bs-toggle="tab" data-bs-target="#emergency"
                                    type="button" role="tab" style="color:#ff6600; font-weight:500;">
                                <i class="bi bi-telephone-fill me-1"></i> Emergency
                            </button>
                        </li>
                    @endcan


                    @can('employee_salary')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                    type="button" role="tab" style="color:#ff6600; font-weight:500;">
                                <i class="bi bi-cash-stack me-1"></i> Salary
                            </button>
                        </li>
                    @endcan

                </ul>


                <!-- Tabs content -->
                <div class="tab-content" id="employeeTabContent">

                    <!-- Personal Info  -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <div class="row g-3">

                            <!-- First Name -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    First Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="first_name" class="form-control" placeholder="Jean Luc"
                                       required
                                       style="border-radius:0;"
                                       pattern="[A-Za-z\s]{3,}"
                                       title="First name must be at least 3 letters, letters only"
                                       oninvalid="this.setCustomValidity('Please enter a valid first name (at least 3 letters)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Last Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="last_name" class="form-control" placeholder="Kawel"
                                       required
                                       style="border-radius:0;"
                                       pattern="[A-Za-z\s]{3,}"
                                       title="Last name must be at least 3 letters, letters only"
                                       oninvalid="this.setCustomValidity('Please enter a valid last name (at least 3 letters)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" placeholder="A Mbumb"
                                       style="border-radius:0;"
                                       pattern="[A-Za-z\s]{3,}"
                                       title="Middle name must be at least 3 letters"
                                       oninvalid="this.setCustomValidity('Please enter a valid middle name (at least 3 letters)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Gender -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Gender <span class="text-danger">*</span>
                                </label>
                                <select name="gender" class="form-select" style="border-radius:0;" required
                                        oninvalid="this.setCustomValidity('Please select gender')"
                                        oninput="this.setCustomValidity('')"
                                        autocomplete="kit-services-sarl">
                                    <option value="">Select</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Date of Birth <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="date_of_birth" class="form-control"
                                       required
                                       style="border-radius:0;"
                                       oninvalid="this.setCustomValidity('Please select a valid date of birth (18+ years old)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl"
                                       id="date_of_birth">
                            </div>

                            <!-- Number Card -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Number Card <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="number_card" class="form-control"
                                       placeholder="NN338638245 / OP87974"
                                       required
                                       style="border-radius:0;"
                                       pattern="[A-Za-z0-9]{10,}"
                                       title="Number Card must be at least 3 alphanumeric characters"
                                       oninvalid="this.setCustomValidity('Please enter a valid Number Card (min 10 alphanumeric chars)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Country -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Country <span class="text-danger">*</span>
                                </label>
                                <select name="pays" id="country" class="form-select" style="border-radius:0;" required
                                        oninvalid="this.setCustomValidity('Please select a country')"
                                        oninput="this.setCustomValidity('')"
                                        autocomplete="kit-services-sarl">
                                    <option value="">Select Country</option>
                                </select>
                            </div>

                            <!-- Marital Status -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Marital Status <span class="text-danger">*</span>
                                </label>
                                <select name="marital_status" class="form-select" style="border-radius:0;"
                                        required
                                        oninvalid="this.setCustomValidity('Please select marital status')"
                                        oninput="this.setCustomValidity('')"
                                        autocomplete="kit-services-sarl">
                                    <option value="">Select</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                        <div class="row g-3">

                            <!-- Number -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Number
                                </label>
                                <input type="text" name="employee_number" class="form-control" placeholder="6"
                                       style="border-radius:0;"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    City
                                </label>
                                <input type="text" name="employee_city" class="form-control" placeholder="Manika"
                                       style="border-radius:0;"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Province -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Province
                                </label>
                                <input type="text" name="employee_province" class="form-control" placeholder="Lualaba"
                                       style="border-radius:0;"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Phone -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Phone
                                </label>
                                <input type="text" name="employee_phone" class="form-control"
                                       placeholder="+243 974 453 545"
                                       style="border-radius:0;"
                                       pattern="\+?\d{9,15}"
                                       title="Enter a valid phone number"
                                       oninvalid="this.setCustomValidity('Please enter a valid phone number')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Emergency Phone -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Emergency Phone
                                </label>
                                <input type="text" name="employee_emergency_phone" class="form-control"
                                       placeholder="+243 830 835 071"
                                       style="border-radius:0;"
                                       pattern="\+?\d{9,15}"
                                       title="Enter a valid emergency phone number"
                                       oninvalid="this.setCustomValidity('Please enter a valid emergency phone number')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                            <!-- Email -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    Email
                                </label>
                                <input type="email" name="employee_email" class="form-control"
                                       placeholder="jeanluckawel45@mail.com"
                                       style="border-radius:0;"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                       title="Enter a valid email address"
                                       oninvalid="this.setCustomValidity('Please enter a valid email address')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="kit-services-sarl">
                            </div>

                        </div>
                    </div>


                    <!-- Company Info -->
                    <div class="tab-pane fade" id="company" role="tabpanel" aria-labelledby="company-tab">
                        <div class="row g-3 mt-3">


                            <!-- Department -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Department') }}</label>
                                <select id="department" name="department" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Department') }}</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Section -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Section') }}</label>
                                <select id="section" name="section" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Section') }}</option>
                                </select>
                            </div>

                            <!-- Job Title -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Job Title') }}</label>
                                <select id="job_title" name="job_title" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Job Title') }}</option>
                                </select>
                            </div>



                            <!-- Contract Type -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Contract Type') }}</label>
                                <select name="contract_type" id="contract_type" class="form-select" style="border-radius:0; color:#ff6600;">
                                    <option value="">{{ __('Select Contract Type') }}</option>
                                    <option value="CDI">CDI</option>
                                    <option value="CDD">CDD</option>
                                    <option value="Stage">Stage</option>
                                   option <option value="Consultant">Consultant</option>
                                </select>
                            </div>

                            <!-- Hire Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Hire Date') }}</label>
                                <input type="date" name="hire_date" class="form-control" style="border-radius:0;">
                            </div>

                            <!-- End Contract Date -->
                            <div class="col-md-6 d-none" id="endContractWrapper">
                                <label class="form-label fw-bold">{{ __('End Contract Date') }}</label>
                                <input type="date" name="end_contract_date" class="form-control" style="border-radius:0;">
                            </div>

                            <!-- Work Location -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Work Location') }}</label>
                                <select name="work_location" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Work Location') }}</option>
                                    <option value="Head Office">{{ __('Head Office') }}</option>
                                    <option value="Kolwezi">{{ __('Kolwezi') }}</option>
                                    <option value="Kolwezi Garage">{{ __('Kolwezi Garage') }}</option>
                                    <option value="Kamoa copper sa">{{ __('Komoa copper sa') }}</option>
{{--                                    <option value="Site B">{{ __('Site B') }}</option>--}}
                                    <option value="Remote">{{ __('Remote') }}</option>
                                </select>
                            </div>

                            <!-- Supervisor -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Supervisor') }}</label>
                                <select name="supervisor" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Supervisor') }}</option>
                                    <option value="NELLY KUZO">{{ __('NELLY KUZO') }}</option>
                                </select>
                            </div>

                            <!-- Employee Type -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Employee Type') }}</label>
                                <select name="employee_type" class="form-select" style="border-radius:0; color:#ff6600;">
                                    <option value="">{{ __('Select Employee Type') }}</option>
                                    <option value="Full Time">{{ __('Full Time') }}</option>
                                    <option value="Part Time">{{ __('Part Time') }}</option>
                                </select>
                            </div>

                        </div>
                    </div>





                    <!-- Education / Children -->



                    <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                        <div class="row g-3 mt-3">

                            <div id="childrenContainer">
                                <div class="row g-3 child-row mb-2 align-items-end">
                                    <!-- Child Full Name -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">{{ __('Full Name') }}</label>
                                        <input type="text" name="children[0][full_name]" class="form-control"
                                               placeholder="{{ __('Full Name') }}" autocomplete="kit-services-sarl" style="border-radius:0;">
                                    </div>

                                    <!-- Child Date of Birth -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">{{ __('Date of Birth') }}</label>
                                        <input type="date" name="children[0][date_of_birth]" class="form-control" style="border-radius:0;">
                                    </div>

                                    <!-- Child Gender -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">{{ __('Gender') }}</label>
                                        <select name="children[0][gender]" class="form-select" style="border-radius:0; color:#ff6600;">
                                            <option value="">{{ __('Select Gender') }}</option>
                                            <option value="M">{{ __('Male') }}</option>
                                            <option value="F">{{ __('Female') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-1 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger btn-sm removeChild" style="border-radius:0;">&times;</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="button" id="addChildBtn" class="btn btn-outline-warning" style="border-radius:0;">
                                    + {{ __('Add Child') }}
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="tab-pane fade" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                        <div class="row g-3 mt-3">

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Relationship') }}</label>
                                <select name="emergency_relationship" class="form-select" style="border-radius:0;">
                                    <option value="">{{ __('Select Relationship') }}</option>
                                    <option value="Father">{{ __('Father') }}</option>
                                    <option value="Mother">{{ __('Mother') }}</option>
                                    <option value="Spouse">{{ __('Spouse') }}</option>
                                    <option value="Brother">{{ __('Brother') }}</option>
                                    <option value="Sister">{{ __('Sister') }}</option>
                                    <option value="Mr">{{ __('Mr') }}</option>
                                    <option value="Mrs">{{ __('Mrs') }}</option>
                                    <option value="Dr">{{ __('Dr') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Full Name') }}</label>
                                <input type="text" name="emergency_full_name" class="form-control"
                                       placeholder="{{ __('Full Name') }}" autocomplete="kit-services-sarl" style="border-radius:0;">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Phone') }}</label>
                                <input type="text" name="emergency_phone" class="form-control"
                                       placeholder="+123456789" autocomplete="kit-services-sarl" style="border-radius:0;">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Address') }}</label>
                                <input type="text" name="emergency_address" class="form-control"
                                       placeholder="{{ __('Address') }}" autocomplete="kit-services-sarl" style="border-radius:0;">
                            </div>

                        </div>
                    </div>

                    <!-- Dependants -->
                    <div class="tab-pane fade" id="dependants" role="tabpanel">
                        <div class="row g-3 mt-3">

                            <div id="dependantsContainer">

                                <!-- FIRST DEPENDANT -->
                                <div class="row g-3 mb-2 dependant-row align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">{{ __('Relationship') }}</label>
                                        <select name="dependants[0][relationship]" class="form-select" style="border-radius:0;">
                                            <option value="">{{ __('Select') }}</option>
                                            <option value="Father">{{ __('Father') }}</option>
                                            <option value="Mother">{{ __('Mother') }}</option>
                                            <option value="Spouse">{{ __('Spouse') }}</option>
                                            <option value="Brother">{{ __('Brother') }}</option>
                                            <option value="Sister">{{ __('Sister') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">{{ __('Full Name') }}</label>
                                        <input type="text" name="dependants[0][full_name]" class="form-control"
                                               placeholder="{{ __('Full Name') }}" style="border-radius:0;" autocomplete="kit-services-sarl">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">{{ __('Phone') }}</label>
                                        <input type="text" name="dependants[0][phone]" class="form-control"
                                               placeholder="{{ __('Phone') }}" style="border-radius:0;" autocomplete="kit-services-sarl">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">{{ __('Address') }}</label>
                                        <input type="text" name="dependants[0][address]" class="form-control"
                                               placeholder="{{ __('Address') }}" style="border-radius:0;" autocomplete="kit-services-sarl">
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <button type="button" id="addDependant" class="btn btn-outline-warning" style="border-radius:0;">
                                    + {{ __('Add Dependant') }}
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Salary -->
                    <div class="tab-pane fade" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                        <div class="row g-3 mt-3">

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Base Salary') }}</label>
                                <input type="number" step="0.01" name="salary_base_salary" class="form-control"
                                       placeholder="0.00" style="border-radius:0;" autocomplete="kit-services-sarl">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Category') }}</label>
                                <select id="categorySelect" name="salary_category" class="form-select" style="border-radius:0; color:#ff6600;">
                                    <option value="">{{ __('Select Category') }}</option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="A3">A3</option>
                                    <option value="C1">C1</option>
                                    <option value="C2">C2</option>
                                    <option value="C3">C3</option>
                                    <option value="C4">C4</option>
                                    <option value="C5">C5</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="D5">D5</option>
                                    <option value="E1">E1</option>
                                    <option value="E2">E2</option>
                                    <option value="E3">E3</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Echelon') }}</label>
                                <input type="text" id="echelonSelect" name="salary_echelon" class="form-control" style="border-radius:0; color:#ff6600;" readonly>
                            </div>

                            <script>
                                const categorySelect = document.getElementById('categorySelect');
                                const echelonInput = document.getElementById('echelonSelect');


                                const categoryToEchelon = {
                                    'A1': 'I',
                                    'A2': 'II',
                                    'A3': 'III',
                                    'B1': 'IV',
                                    'B2': 'V',
                                    'B3': 'VI',
                                    'B4': 'VII',
                                    'B5': 'VIII',
                                    'C1': 'IX',
                                    'C2': 'X',
                                    'C3': 'XI',
                                    'C4': 'XII',
                                    'C5': 'XIII',
                                    'D1': 'XIV',
                                    'D2': 'XV',
                                    'D3': 'XVI',
                                    'D4': 'XVII',
                                    'D5': 'XVIII',
                                    'E1': 'XIX',
                                    'E2': 'XX',
                                    'E3': 'XXI'
                                };


                                categorySelect.addEventListener('change', function() {
                                    const catValue = this.value;
                                    echelonInput.value = categoryToEchelon[catValue] || '';
                                });


                                categorySelect.dispatchEvent(new Event('change'));
                            </script>



                            <div class="col-md-3">
                                <label class="form-label fw-bold">{{ __('Currency') }}</label>
                                <select name="salary_currency" class="form-select" style="border-radius:0; color:#ff6600;">
                                    <option value="USD">USD</option>
                                    <option value="CDF">CDF</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- Photo -->
                    <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Upload Photo</label>
                                <input type="file" name="photo" class="form-control" id="photoInput" accept="image/*"
                                       style="border-radius:0;">
                                <div class="mt-2">
                                    <img id="photoPreview" src="#" alt="Preview" class="img-fluid d-none"
                                         style="max-height: 150px; border: 1px solid #FF6600;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" id="saveBtn" class="btn btn-primary">
                        <span id="btnText">Save</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.getElementById('photoInput').addEventListener('change', function (event) {
            const [file] = event.target.files;
            const preview = document.getElementById('photoPreview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });

        let childIndex = 1;

        document.getElementById('addChildBtn').addEventListener('click', function () {
            const container = document.getElementById('childrenContainer');

            const childRow = document.createElement('div');
            childRow.classList.add('row', 'g-3', 'child-row', 'mb-2');
            childRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="children[${childIndex}][full_name]" class="form-control" placeholder="Full Name" autocomplete="kit-services-sarl" style="border-radius:0;">
            </div>
            <div class="col-md-4">
                <input type="date" name="children[${childIndex}][date_of_birth]" class="form-control" style="border-radius:0;">
            </div>
            <div class="col-md-3">
                <select name="children[${childIndex}][gender]" class="form-select" style="border-radius:0; color:#ff6600;">
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm removeChild" style="border-radius:0;">&times;</button>
            </div>
        `;
            container.appendChild(childRow);
            childIndex++;
        });


        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('removeChild')) {
                e.target.closest('.child-row').remove();
            }
        });


        let dependantIndex = 1;

        document.getElementById('addDependant').addEventListener('click', function () {
            const container = document.getElementById('dependantsContainer');

            const row = document.createElement('div');
            row.className = 'row g-3 mb-2 dependant-row';

            row.innerHTML = `
        <div class="col-md-3">
            <select name="dependants[${dependantIndex}][relationship]" class="form-select">
                <option value="">Select</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Spouse">Spouse</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="dependants[${dependantIndex}][full_name]" class="form-control" placeholder="Full Name">
        </div>

        <div class="col-md-3">
            <input type="text" name="dependants[${dependantIndex}][phone]" class="form-control" placeholder="Phone">
        </div>

        <div class="col-md-2">
            <input type="text" name="dependants[${dependantIndex}][address]" class="form-control" placeholder="Address">
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm removeDependant">X</button>
        </div>
    `;

            container.appendChild(row);
            dependantIndex++;

            row.querySelector('.removeDependant').onclick = () => row.remove();
        });


        //     == country

        $(document).ready(function () {
            const $select = $('#country');

            fetch('https://countriesnow.space/api/v0.1/countries/flag/images')
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {


                        const rdcOption = new Option("RD Congo", "Democratic Republic of the Congo", false, false);
                        $(rdcOption).attr('data-flag', "https://flagcdn.com/w20/cd.png");
                        $select.append(rdcOption);

                        data.data.forEach(country => {

                            if (country.name === "Democratic Republic of the Congo") return;

                            const option = new Option(country.name, country.name, false, false);
                            $(option).attr('data-flag', country.flag);
                            $select.append(option);
                        });


                        $select.select2({
                            templateResult: formatCountry,
                            templateSelection: formatCountry,
                            width: '100%'
                        });
                    }
                })
                .catch(error => console.error('Error fetching countries:', error));


            function formatCountry(country) {
                if (!country.id) return country.text;
                const flagUrl = $(country.element).attr('data-flag');
                if (flagUrl) {
                    return $(
                        `<span style="display:flex; align-items:center;">
                    <img src="${flagUrl}" srcset="${flagUrl.replace('w20', 'w40')} 2x" width="20" style="margin-right:8px;" alt="${country.text}" />
                    ${country.text}
                </span>`
                    );
                }
                return country.text;
            }
        });


        // company
        document.getElementById('contract_type').addEventListener('change', function () {
            const endWrapper = document.getElementById('endContractWrapper');
            const endInput = document.getElementById('end_contract_date');

            if (['CDD', 'Stage', 'Consultant'].includes(this.value)) {
                endWrapper.classList.remove('d-none');
                endInput.setAttribute('', ' ');
            } else {
                endWrapper.classList.add('d-none');
                endInput.removeAttribute('');
                endInput.value = '';
            }
        });





            // ====== SUCCESS MESSAGE ======
            @if(session('success'))
            Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            iconColor: '#FF6600', // orange Kit Service
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#FF6600',
            confirmButtonText: 'Ok',
            customClass: {
            popup: 'shadow-lg rounded-2xl',
            title: 'fw-bold fs-5',
            content: 'fs-6'
        },
            timer: 3000,
            timerProgressBar: true,
        }).then(() => {
            // Redirection après que le message soit affiché
            window.location.href = "{{ route('employee.list') }}";
        });
            @endif

            // ====== CUSTOM ERROR MESSAGE ======
            @if(session('error'))
            Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            iconColor: '#FF3300', // rouge Kit Service
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#FF3300',
            confirmButtonText: 'Ok',
            customClass: {
            popup: 'shadow-lg rounded-2xl',
            title: 'fw-bold fs-5',
            content: 'fs-6'
        },
            // Pas de timer → se ferme seulement quand l'utilisateur clique sur OK
        });
            @endif

            // ====== VALIDATION ERRORS FROM LARAVEL ======
            @if ($errors->any())
            let errorMessages = `
            @foreach ($errors->all() as $error)
            • {{ $error }} <br>
            @endforeach
            `;
            Swal.fire({
            title: 'Validation Errors!',
            html: errorMessages,
            icon: 'error',
            iconColor: '#FF3300',
            background: '#fff',
            color: '#333',
            confirmButtonColor: '#FF3300',
            confirmButtonText: 'Ok',
            customClass: {
            popup: 'shadow-lg rounded-2xl',
            title: 'fw-bold fs-5',
            content: 'fs-6'
        },
            // Pas de timer → se ferme seulement quand l'utilisateur clique sur OK
        });
        @endif




        // Calculer la date limite pour 18 ans
        const dobInput = document.getElementById('date_of_birth');
        const today = new Date();
        const year = today.getFullYear() - 18; // minimum 18 ans
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        dobInput.max = `${year}-${month}-${day}`;



        // ====== FRONT-END VALIDATION AVANT SUBMIT ======
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault(); // empêche le submit immédiat

            let form = this;
            let invalidFields = [];

            // Parcours tous les champs requis
            form.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    let label = field.closest('.col-md-4, .col-md-6, .col-md-3')?.querySelector('label')?.innerText || field.name;
                    invalidFields.push(label.replace('*','').trim());
                } else if (field.pattern) {
                    let regex = new RegExp(field.pattern);
                    if (!regex.test(field.value)) {
                        let label = field.closest('.col-md-4, .col-md-6, .col-md-3')?.querySelector('label')?.innerText || field.name;
                        invalidFields.push(label.replace('*','').trim() + " (format incorrect)");
                    }
                }
            });

            if (invalidFields.length > 0) {
                Swal.fire({
                    title: 'Please fix the following errors',
                    html: invalidFields.map(f => '• ' + f).join('<br>'),
                    icon: 'error',
                    iconColor: '#FF3300',
                    background: '#fff',
                    color: '#333',
                    confirmButtonColor: '#FF3300',
                    confirmButtonText: 'Ok',
                    customClass: {
                        popup: 'shadow-lg rounded-2xl',
                        title: 'fw-bold fs-5',
                        content: 'fs-6'
                    }
                });
                return false; // bloque le submit si erreurs
            }

            // Si tout est OK, on submit normalement
            form.submit();
        });









        $(document).ready(function(){

            // Quand le Department change
            $('#department').change(function(){
                let departmentId = $(this).val();
                $('#section').html('<option value="">Select Section</option>');
                $('#job_title').html('<option value="">Select Job Title</option>');

                if(departmentId){
                    $.get('/get-sections/' + departmentId, function(data){
                        $.each(data, function(key, value){
                            $('#section').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    });
                }
            });

            // Quand la Section change
            $('#section').change(function(){
                let sectionId = $(this).val();
                $('#job_title').html('<option value="">Select Job Title</option>');

                if(sectionId){
                    $.get('/get-job-titles/' + sectionId, function(data){
                        $.each(data, function(key, value){
                            $('#job_title').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    });
                }
            });

        });



        const form = document.querySelector('form'); // cible ton formulaire
        const saveBtn = document.getElementById('saveBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function(e) {
            // Empêche le double clic
            saveBtn.disabled = true;

            // Affiche le spinner
            btnSpinner.classList.remove('d-none');

            // Optionnel : change le texte du bouton
            btnText.textContent = 'Saving...';
        });
    </script>







@endsection
