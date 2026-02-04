@extends('layoutsddd.app')

@section('title', 'Edit Employee - KIT SERVICES')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Edit Employee info
                <spam>{{ $employee->employee_id ?? '' }}</spam>
            </h3>
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

                    <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>

                </ol>
            </nav>

        </div>

        <div class="card-body">
            <form action="{{ route('employee.update', $employee) }}" method="POST" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @method('PUT')
                <ul class="nav nav-tabs mb-4" id="employeeTab" role="tablist" style="border-radius:0;">
                    {{-- Onglet Personal toujours visible --}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button" role="tab"
                                style="color:#FF6600; font-weight:500;">
                            <i class="bi bi-person-fill me-1"></i> Personal
                        </button>
                    </li>

                    {{-- Address --}}
                    @can('employee_address')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-geo-alt-fill me-1"></i> Address
                            </button>
                        </li>
                    @endcan

                    {{-- Company --}}
                    @can('employee_company')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-briefcase-fill me-1"></i> Company
                            </button>
                        </li>
                    @endcan

                    {{-- Children --}}
                    @can('employee_children')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="children-tab" data-bs-toggle="tab" data-bs-target="#children"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-book-fill me-1"></i> Children
                            </button>
                        </li>
                    @endcan

                    {{-- Dependants --}}
                    @can('employee_dependants')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dependants-tab" data-bs-toggle="tab" data-bs-target="#dependants"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-people-fill me-1"></i> Dependants
                            </button>
                        </li>
                    @endcan

                    {{-- Emergency --}}
                    @can('employee_emergency')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="emergency-tab" data-bs-toggle="tab" data-bs-target="#emergency"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-telephone-fill me-1"></i> Emergency
                            </button>
                        </li>
                    @endcan

                    {{-- Salary --}}
                    @can('employee_salary')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-cash-stack me-1"></i> Salary
                            </button>
                        </li>
                    @endcan

                    {{-- Photo --}}
                    @can('employee_photo')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo"
                                    type="button" role="tab" style="color:#FF6600; font-weight:500;">
                                <i class="bi bi-camera-fill me-1"></i> Photo
                            </button>
                        </li>
                    @endcan
                </ul>

                <!-- Tabs content -->
                <div class="tab-content" id="employeeTabContent">

                    {{-- Personal --}}
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <div class="row g-3 mt-2">


                            <div class="col-md-4 d-flex flex-column align-items-start">
                                @if($employee->photo)
                                    <label class="form-label fw-bold">Current Photo</label>
                                    <img src="{{ asset('storage/'.$employee->photo) }}"
                                         alt="Photo"
                                         class="rounded mb-3"
                                         width="180"
                                         style="border:1px solid #ddd; padding:4px;">
                                @endif
                            </div>


                            <div class="col-md-4">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">First Name </label>
                                    <input type="text" name="first_name" class="form-control"
                                           value="{{ old('first_name', $employee->first_name) }}"
                                           style="border-radius:0;">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control"
                                           value="{{ old('last_name', $employee->last_name) }}"
                                           style="border-radius:0;">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-bold">Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control"
                                           value="{{ old('middle_name', $employee->middle_name) }}"
                                           style="border-radius:0;">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select"   style="border-radius:0;">
                                        <option value="">Select</option>
                                        <option
                                            value="M" {{ old('gender', $employee->gender) == 'M' ? 'selected' : '' }}>
                                            Male
                                        </option>
                                        <option
                                            value="F" {{ old('gender', $employee->gender) == 'F' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date of Birth <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                           value="{{ old('date_of_birth', $employee->date_of_birth) }}"
                                           style="border-radius:0;">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-bold">Number Card <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="number_card" class="form-control"
                                           value="{{ old('number_card', $employee->number_card) }}"
                                           style="border-radius:0;">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-bold">Country <span class="text-danger">*</span></label>
                                    <select name="pays" id="country" class="form-select"
                                            data-selected="{{ old('pays') ?? ($employee->pays ?? '') }}"
                                            style="border-radius:0;">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Marital Status <span class="text-danger">*</span></label>
                                    <select name="marital_status" class="form-select"   style="border-radius:0;">
                                        <option value="">Select</option>
                                        <option
                                            value="single" {{ old('marital_status', $employee->marital_status) == 'single' ? 'selected' : '' }}>
                                            Single
                                        </option>
                                        <option
                                            value="married" {{ old('marital_status', $employee->marital_status) == 'married' ? 'selected' : '' }}>
                                            Married
                                        </option>
                                        <option
                                            value="divorced" {{ old('marital_status', $employee->marital_status) == 'divorced' ? 'selected' : '' }}>
                                            Divorced
                                        </option>
                                        <option
                                            value="widowed" {{ old('marital_status', $employee->marital_status) == 'widowed' ? 'selected' : '' }}>
                                            Widowed
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="tab-pane fade" id="address" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Address Number</label>
                                <input type="text" name="address_number" class="form-control"
                                       value="{{ old('address_number', $employee->address?->number) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">City</label>
                                <input type="text" name="address_city" class="form-control"
                                       value="{{ old('address_city', $employee->address?->city) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Province</label>
                                <input type="text" name="address_province" class="form-control"
                                       value="{{ old('address_province', $employee->address?->province) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="address_phone" class="form-control"
                                       value="{{ old('address_phone', $employee->address?->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Emergency Phone</label>
                                <input type="text" name="address_emergency_phone" class="form-control"
                                       value="{{ old('address_emergency_phone', $employee->address?->emergency_phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="address_email" class="form-control"
                                       value="{{ old('address_email', $employee->address?->email) }}">
                            </div>
                        </div>
                    </div>

                    {{-- Company --}}
                    <div class="tab-pane fade" id="company" role="tabpanel">
                        <div class="row g-3">

                            {{-- Department --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Department</label>
                                <select id="department" name="department" class="form-select" style="border-radius:0;">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department', $employee->company?->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Section --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Section</label>
                                <select id="section" name="section" class="form-select" style="border-radius:0;">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}"
                                            {{ old('section', $employee->company?->section_id) == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Job Title --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Job Title</label>
                                <select id="job_title" name="job_title" class="form-select" style="border-radius:0;">
                                    <option value="">Select Job Title</option>
                                    @foreach($jobTitles as $job)
                                        <option value="{{ $job->id }}"
                                            {{ old('job_title', $employee->company?->job_title_id) == $job->id ? 'selected' : '' }}>
                                            {{ $job->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- Contract Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Contract Type</label>
                                <select name="contract_type" id="contract_type" class="form-select"
                                        style="border-radius:0;">
                                    <option value="">Select</option>
                                    @foreach(['CDI','CDD','Stage','Consultant'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('contract_type', $employee->company?->contract_type) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Hire Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Hire Date</label>
                                <input
                                    type="date"
                                    name="hire_date"
                                    class="form-control"
                                    style="border-radius:0;"
                                    value="{{ old('hire_date', $employee->company?->hire_date) }}">
                            </div>

                            {{-- End Contract Date --}}
                            <div
                                class="col-md-6 {{ in_array(old('contract_type', $employee->company?->contract_type), ['CDD','Stage','Consultant']) ? '' : 'd-none' }}"
                                id="endContractWrapper">
                                <label class="form-label fw-bold">End Contract Date</label>
                                <input
                                    type="date"
                                    id="end_contract_date"
                                    name="end_contract_date"
                                    class="form-control"
                                    style="border-radius:0;"
                                    value="{{ old('end_contract_date', $employee->company?->end_contract_date) }}">
                            </div>

                            {{-- Work Location --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Work Location</label>
                                <select name="work_location" class="form-select" style="border-radius:0;">
                                    <option value="">Select</option>
                                    @foreach(['Site','Office','Remote','Hybrid'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('work_location', $employee->company?->work_location) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Supervisor --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Supervisor</label>
                                <select name="supervisor" class="form-select" style="border-radius:0;">
                                    <option value="">Select</option>
                                    @foreach(['HR Manager','Operations Manager','IT Manager','Site Manager'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('supervisor', $employee->company?->supervisor) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Employee Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Employee Type</label>
                                <select name="employee_type" class="form-select" style="border-radius:0;">
                                    <option value="">Select</option>
                                    @foreach(['Full Time', 'Part Time'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('employee_type', $employee->company?->employee_type) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    {{-- Children --}}
                    <div class="tab-pane fade" id="children" role="tabpanel" aria-labelledby="children-tab">
                        <div class="row g-3 mt-3">

                            <div id="childrenContainer">
                                @forelse($employee->children ?? [] as $i => $child)
                                    <div class="row g-3 child-row mb-2 align-items-end" data-index="{{ $i }}">
                                        <input type="hidden" name="children[{{ $i }}][id]" value="{{ $child->id }}">

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Full Name</label>
                                            <input type="text" name="children[{{ $i }}][child_full_name]"
                                                   class="form-control"
                                                   value="{{ old("children.$i.child_full_name", $child->full_name) }}"
                                                   autocomplete="off" style="border-radius:0;">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Date of Birth</label>
                                            <input type="date" name="children[{{ $i }}][child_date_of_birth]"
                                                   class="form-control"
                                                   value="{{ old("children.$i.child_date_of_birth", $child->date_of_birth) }}"
                                                   style="border-radius:0;">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Gender</label>
                                            <select name="children[{{ $i }}][child_gender]" class="form-select"
                                                    style="border-radius:0; color:#ff6600;">
                                                <option value="">Select Gender</option>
                                                <option
                                                    value="M" {{ old("children.$i.child_gender", $child->gender) == 'M' ? 'selected' : '' }}>
                                                    Male
                                                </option>
                                                <option
                                                    value="F" {{ old("children.$i.child_gender", $child->gender) == 'F' ? 'selected' : '' }}>
                                                    Female
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-1 d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger btn-sm removeChild"
                                                    style="border-radius:0;">&times;
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    {{-- Aucun enfant existant --}}
                                @endforelse
                            </div>

                            <div class="col-12">
                                <button type="button" id="addChildBtn" class="btn btn-outline-warning"
                                        style="border-radius:0;">
                                    + Add Child
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- Dependants --}}
                    <div class="tab-pane fade" id="dependants" role="tabpanel" aria-labelledby="dependants-tab">
                        <div class="row g-3 mt-3">

                            <div id="dependantsContainer">
                                @forelse($employee->dependants ?? [] as $i => $dep)
                                    <div class="row g-3 dependant-row mb-2 align-items-end" data-index="{{ $i }}">
                                        <input type="hidden" name="dependants[{{ $i }}][id]" value="{{ $dep->id }}">

                                        {{-- Full Name --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Full Name</label>
                                            <input type="text" name="dependants[{{ $i }}][dep_full_name]"
                                                   class="form-control"
                                                   value="{{ $dep->full_name }}"
                                                   autocomplete="off" style="border-radius:0;">
                                        </div>

                                        {{-- Relationship --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Relationship</label>
                                            <select name="dependants[{{ $i }}][dep_relationship]" class="form-select"
                                                    style="border-radius:0; color:#ff6600;">
                                                <option value="">Select</option>
                                                @foreach(['Father','Mother','Spouse','Brother','Sister','Mr','Mrs','Dr'] as $rel)
                                                    <option
                                                        value="{{ $rel }}" {{ $dep->relationship == $rel ? 'selected' : '' }}>
                                                        {{ $rel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Phone</label>
                                            <input type="text" name="dependants[{{ $i }}][dep_phone]"
                                                   class="form-control"
                                                   value="{{ $dep->phone }}" style="border-radius:0;">
                                        </div>

                                        {{-- Address --}}
                                        <div class="col-md-2">
                                            <label class="form-label fw-bold">Address</label>
                                            <input type="text" name="dependants[{{ $i }}][dep_address]"
                                                   class="form-control"
                                                   value="{{ $dep->address }}" style="border-radius:0;">
                                        </div>

                                        {{-- Bouton Supprimer --}}
                                        <div class="col-md-1 d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger btn-sm removeDependant"
                                                    style="border-radius:0;">&times;
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    {{-- Aucun dépendant existant --}}
                                @endforelse
                            </div>

                            {{-- Bouton Ajouter --}}
                            <div class="col-12">
                                <button type="button" id="addDependantBtn" class="btn btn-outline-warning"
                                        style="border-radius:0;">
                                    + Add Dependant
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- Emergency --}}
                    <div class="tab-pane fade" id="emergency" role="tabpanel" aria-labelledby="emergency-tab">
                        <div class="row g-3 mt-3">


                            <div class="col-md-3">
                                <label class="form-label fw-bold">Relationship</label>
                                <select name="emergency_relationship" class="form-select" style="border-radius:0;">
                                    <option value="">Select Relationship</option>
                                    @foreach(['Father','Mother','Spouse','Brother','Sister','Mr','Mrs','Dr'] as $rel)
                                        <option value="{{ $rel }}"
                                            {{ old('emergency_relationship', $employee->emergencies?->relationship) == $rel ? 'selected' : '' }}>
                                            {{ $rel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Full Name --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="emergency_full_name" class="form-control"
                                       value="{{ old('emergency_full_name', $employee->emergencies?->full_name) }}"
                                       style="border-radius:0;">
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="emergency_phone" class="form-control"
                                       value="{{ old('emergency_phone', $employee->emergencies?->phone) }}"
                                       style="border-radius:0;">
                            </div>

                            {{-- Address --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Address</label>
                                <input type="text" name="emergency_address" class="form-control"
                                       value="{{ old('emergency_address', $employee->emergencies?->address) }}"
                                       style="border-radius:0;">
                            </div>

                        </div>
                    </div>


                    {{-- Salary --}}
                    <div class="tab-pane fade" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                        <div class="row g-3 mt-3">

                            {{-- Base Salary --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Base Salary</label>
                                <input type="number" step="0.01" name="salary_base_salary" class="form-control"
                                       value="{{ old('salary_base_salary', $employee->salaries?->base_salary) }}"
                                       placeholder="0.00" style="border-radius:0;">
                            </div>

                            {{-- Category --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="salary_category" class="form-select"
                                        style="border-radius:0; color:#ff6600;">
                                    <option value="">Select Category</option>
                                    @foreach(['A1','A2','A3','B1','B2','C1','C2'] as $cat)
                                        <option value="{{ $cat }}"
                                            {{ old('salary_category', $employee->salaries?->category) == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Echelon --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Echelon</label>
                                <select name="salary_echelon" class="form-select"
                                        style="border-radius:0; color:#ff6600;">
                                    <option value="">Select Echelon</option>
                                    @foreach(['I','II','III','IV','V'] as $echelon)
                                        <option value="{{ $echelon }}"
                                            {{ old('salary_echelon', $employee->salaries?->echelon) == $echelon ? 'selected' : '' }}>
                                            {{ $echelon }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Currency --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Currency</label>
                                <select name="salary_currency" class="form-select"
                                        style="border-radius:0; color:#ff6600;">
                                    @foreach(['USD','CDF'] as $currency)
                                        <option value="{{ $currency }}"
                                            {{ old('salary_currency', $employee->salaries?->currency) == $currency ? 'selected' : '' }}>
                                            {{ $currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>


                    {{-- Photo --}}
                    <div class="tab-pane fade" id="photo" role="tabpanel">
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Upload Photo</label>
                                <input type="file" name="photo" class="form-control">

                                @if($employee->photo)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Current Photo:</p>
                                        <img src="{{ asset('storage/'.$employee->photo) }}"
                                             alt="Photo"
                                             class="rounded"
                                             width="120"
                                             style="border:1px solid #ddd; padding:2px;">

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success  me-2">Update</button>
                    <button type="reset" class="btn btn-success ">Reset</button>
                </div>

            </form>
        </div>
    </div>


    <script>
        // child
        let childIndex = {{ $employee->children->count() ?? 0 }};

        document.getElementById('addChildBtn').addEventListener('click', function () {
            const container = document.getElementById('childrenContainer');

            const row = document.createElement('div');
            row.classList.add('row', 'g-3', 'child-row', 'mb-2', 'align-items-end');
            row.setAttribute('data-index', childIndex);

            row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="children[${childIndex}][child_full_name]" class="form-control" placeholder="Full Name" style="border-radius:0;">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Date of Birth</label>
                <input type="date" name="children[${childIndex}][child_date_of_birth]" class="form-control" style="border-radius:0;">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Gender</label>
                <select name="children[${childIndex}][child_gender]" class="form-select" style="border-radius:0; color:#ff6600;">
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="col-md-1 d-flex justify-content-end">
                <button type="button" class="btn btn-danger btn-sm removeChild" style="border-radius:0;">&times;</button>
            </div>
        `;

            container.appendChild(row);
            childIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeChild')) {
                e.target.closest('.child-row').remove();
            }
        });


        // dependant

        let depIndex = {{ $employee->dependants->count() ?? 0 }};

        document.getElementById('addDependantBtn').addEventListener('click', function () {
            const container = document.getElementById('dependantsContainer');

            const row = document.createElement('div');
            row.classList.add('row', 'g-3', 'dependant-row', 'mb-2', 'align-items-end');
            row.setAttribute('data-index', depIndex);

            row.innerHTML = `
            <div class="col-md-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="dependants[${depIndex}][dep_full_name]" class="form-control" placeholder="Full Name" style="border-radius:0;">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Relationship</label>
                <select name="dependants[${depIndex}][dep_relationship]" class="form-select" style="border-radius:0; color:#ff6600;">
                    <option value="">Select</option>
                    <option value="Father">Father</option>
                    <option value="Mother">Mother</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Brother">Brother</option>
                    <option value="Sister">Sister</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="dependants[${depIndex}][dep_phone]" class="form-control" style="border-radius:0;">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Address</label>
                <input type="text" name="dependants[${depIndex}][dep_address]" class="form-control" style="border-radius:0;">
            </div>
            <div class="col-md-1 d-flex justify-content-end">
                <button type="button" class="btn btn-danger btn-sm removeDependant" style="border-radius:0;">&times;</button>
            </div>
        `;

            container.appendChild(row);
            depIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeDependant')) {
                e.target.closest('.dependant-row').remove();
            }
        });

        // country

        $(document).ready(function () {

            const $select = $('#country');
            const selectedCountry = $select.data('selected');

            fetch('https://countriesnow.space/api/v0.1/countries/flag/images')
                .then(response => response.json())
                .then(res => {

                    if (res.error) return;


                    const rdcValue = "Democratic Republic of the Congo";
                    const rdcOption = new Option(
                        "RD Congo",
                        rdcValue,
                        false,
                        selectedCountry === rdcValue
                    );

                    $(rdcOption).attr('data-flag', 'https://flagcdn.com/w20/cd.png');
                    $select.append(rdcOption);


                    res.data.forEach(country => {

                        if (country.name === rdcValue) return;

                        const option = new Option(
                            country.name,
                            country.name,
                            false,
                            country.name === selectedCountry
                        );

                        $(option).attr('data-flag', country.flag);
                        $select.append(option);
                    });


                    $select.select2({
                        width: '100%',
                        placeholder: 'Select Country',
                        templateResult: formatCountry,
                        templateSelection: formatCountry
                    });


                    if (selectedCountry) {
                        $select.val(selectedCountry).trigger('change');
                    }
                })
                .catch(err => console.error(err));

            function formatCountry(country) {
                if (!country.id) return country.text;

                const flag = $(country.element).data('flag');

                if (!flag) return country.text;

                return $(`
            <span style="display:flex;align-items:center;">
                <img src="${flag}" width="20"
                     style="margin-right:8px" alt="">
                ${country.text}
            </span>
        `);
            }
        });

        $(document).ready(function(){

            function loadSections(departmentId, selectedSection = null) {
                $('#section').html('<option value="">Select Section</option>');
                $('#job_title').html('<option value="">Select Job Title</option>');
                if(departmentId){
                    $.get('/get-sections/' + departmentId, function(data){
                        $.each(data, function(key, value){
                            let selected = (value.id == selectedSection) ? 'selected' : '';
                            $('#section').append('<option value="'+value.id+'" '+selected+'>'+value.name+'</option>');
                        });
                    });
                }
            }

            function loadJobTitles(sectionId, selectedJob = null) {
                $('#job_title').html('<option value="">Select Job Title</option>');
                if(sectionId){
                    $.get('/get-job-titles/' + sectionId, function(data){
                        $.each(data, function(key, value){
                            let selected = (value.id == selectedJob) ? 'selected' : '';
                            $('#job_title').append('<option value="'+value.id+'" '+selected+'>'+value.name+'</option>');
                        });
                    });
                }
            }

            // Pré-charger sections et job titles si déjà sélectionné
            let currentDepartment = $('#department').val();
            let currentSection = "{{ old('section', $employee->company?->section_id) }}";
            let currentJob = "{{ old('job_title', $employee->company?->job_title_id) }}";

            if(currentDepartment){
                loadSections(currentDepartment, currentSection);
            }
            if(currentSection){
                loadJobTitles(currentSection, currentJob);
            }

            // Quand le Department change
            $('#department').change(function(){
                let departmentId = $(this).val();
                loadSections(departmentId);
            });

            // Quand la Section change
            $('#section').change(function(){
                let sectionId = $(this).val();
                loadJobTitles(sectionId);
            });

        });
    </script>


@endsection

