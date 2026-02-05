<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee\Address;
use App\Models\Employee\Children;
use App\Models\Employee\Company;
use App\Models\Employee\Dependant;
use App\Models\Employee\Emergency;
use App\Models\Employee\Employee;
use App\Models\Employee\Salary;
use App\Models\JobTitle;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $departments = Department::all();
        $sections = Section::all();
        $jobTitles = JobTitle::all();

        return view('Employee.create', compact('departments', 'sections', 'jobTitles'));
    }

    /**
     * Store a newly created resource in storage.
     */


//    public function store(Request $request)
//    {
//
//        $validated = $request->validate([
//            'first_name' => 'nullable| string',
//            'last_name'  => 'nullable| string',
//            'middle_name'=> 'nullable|string',
//            'gender'     => 'nullable|string',
//            'date_of_birth' => 'nullable|date',
//            'number_card'   => 'nullable|string',
//            'pays'          => 'nullable|string',
//            'marital_status'=> 'nullable|string',
//            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//        ]);
//
//
//        $addressData = $request->validate([
//            'employee_number' => ' string',
//            'employee_city'   => ' string',
//            'employee_province' => ' string',
//            'employee_phone'  => ' string',
//            'employee_email'  => ' email',
//            'employee_emergency_phone' => 'nullable|string',
//        ]);
//        $addressData = [
//            'number' => $addressData['employee_number'],
//            'city' => $addressData['employee_city'],
//            'province' => $addressData['employee_province'],
//            'phone' => $addressData['employee_phone'],
//            'email' => $addressData['employee_email'],
//            'emergency_phone' => $addressData['employee_emergency_phone'] ?? null,
//        ];
//
//
//        $companyData = $request->validate([
//            'job_title' => ' string',
//            'department'=> ' string',
//            'section'   => ' string',
//            'contract_type' => ' in:CDI,CDD,Stage,Consultant',
//            'hire_date' => ' date',
//            'end_contract_date' => [
//                'nullable',
//                'date',
//                function ($attribute, $value, $fail) use ($request) {
//                    if (in_array($request->contract_type, ['CDD','Stage','Consultant']) && empty($value)) {
//                        $fail('End contract date is required for this contract type.');
//                    }
//                },
//            ],
//            'work_location' => ' string',
//            'supervisor' => ' string',
//            'employee_type' => ' in:Full Time,Part Time',
//        ]);
//
//
//        $salaryRequest = $request->validate([
//            'salary_base_salary' => 'nullable|numeric',
//            'salary_category'    => 'nullable|string',
//            'salary_echelon'     => 'nullable|string',
//            'salary_currency'    => ' in:USD,CDF',
//        ]);
//        $salaryData = [
//            'base_salary' => $salaryRequest['salary_base_salary'] ?? 0,
//            'category'    => $salaryRequest['salary_category'] ?? null,
//            'echelon'     => $salaryRequest['salary_echelon'] ?? null,
//            'currency'    => $salaryRequest['salary_currency'],
//        ];
//
//
//        $emergencyRequest = $request->validate([
//            'emergency_relationship' => 'nullable|string',
//            'emergency_full_name'    => 'nullable|string',
//            'emergency_phone'        => 'nullable|string',
//            'emergency_address'      => 'nullable|string',
//        ]);
//        $emergencyData = [
//            'relationship' => $emergencyRequest['emergency_relationship'] ?? null,
//            'full_name'    => $emergencyRequest['emergency_full_name'] ?? null,
//            'phone'        => $emergencyRequest['emergency_phone'] ?? null,
//            'address'      => $emergencyRequest['emergency_address'] ?? null,
//        ];
//
//
//        $childrenRequest = $request->validate([
//            'children.*.full_name'     => ' string',
//            'children.*.date_of_birth' => ' date',
//            'children.*.gender'        => ' in:M,F',
//        ]);
//
//        $dependantsRequest = $request->validate([
//            'dependants'                => 'nullable|array',
//            'dependants.*.relationship' => ' string',
//            'dependants.*.full_name'    => ' string',
//            'dependants.*.phone'        => 'nullable|string',
//            'dependants.*.address'      => 'nullable|string',
//        ]);
//
//
//        if ($request->hasFile('photo')) {
//            $validated['photo'] = $request->file('photo')->store('photos', 'public');
//        }
//
//
//        DB::transaction(function () use ($validated, $addressData, $companyData, $salaryData, $emergencyData, $childrenRequest, $dependantsRequest) {
//
//
//            $latest = Employee::latest('id')->first();
//            $nextId = $latest ? $latest->id + 1 : 1;
//            $validated['employee_id'] = 'KAM_KIT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
//            $validated['status'] = 1;
//
//
//            $employee = Employee::create($validated);
//
//
//            Address::create(array_merge($addressData, [
//                'employee_id' => $employee->employee_id,
//            ]));
//
//
//            Company::create(array_merge($companyData, [
//                'employee_id' => $employee->employee_id,
//            ]));
//
//
//            Salary::create(array_merge($salaryData, [
//                'employee_id' => $employee->employee_id,
//            ]));
//
//
//            if (array_filter($emergencyData)) {
//                Emergency::create(array_merge($emergencyData, [
//                    'employee_id' => $employee->employee_id,
//                ]));
//            }
//
//
//            if (!empty($childrenRequest['children'])) {
//                foreach ($childrenRequest['children'] as $child) {
//                    Children::create([
//                        'employee_id'   => $employee->employee_id,
//                        'full_name'     => $child['full_name'],
//                        'date_of_birth' => $child['date_of_birth'],
//                        'gender'        => $child['gender'],
//                    ]);
//                }
//            }
//
//            if (!empty($dependantsRequest['dependants'])) {
//                foreach ($dependantsRequest['dependants'] as $dependant) {
//                    Dependant::create([
//                        'employee_id' => $employee->employee_id,
//                        'relationship'=> $dependant['relationship'],
//                        'full_name'   => $dependant['full_name'],
//                        'phone'       => $dependant['phone'] ?? null,
//                        'address'     => $dependant['address'] ?? null,
//                    ]);
//                }
//            }
//
//        });
//
//        return redirect()
//            ->route('employee.list')
//            ->with('success', 'Employee created successfully!');
//    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string',
            'last_name'  => 'nullable|string',
            'middle_name'=> 'nullable|string',
            'gender'     => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'number_card'   => 'nullable|string',
            'pays'          => 'nullable|string',
            'marital_status'=> 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $addressData = $request->validate([
            'employee_number' => 'nullable|string',
            'employee_city'   => 'nullable|string',
            'employee_province' => 'nullable|string',
            'employee_phone'  => 'nullable|string',
            'employee_email'  => 'nullable|email',
            'employee_emergency_phone' => 'nullable|string',
        ]);
        $addressData = [
            'number' => $addressData['employee_number'] ?? null,
            'city' => $addressData['employee_city'] ?? null,
            'province' => $addressData['employee_province'] ?? null,
            'phone' => $addressData['employee_phone'] ?? null,
            'email' => $addressData['employee_email'] ?? null,
            'emergency_phone' => $addressData['employee_emergency_phone'] ?? null,
        ];

        $companyData = $request->validate([
            'job_title' => 'nullable|string',
            'department'=> 'nullable|string',
            'section'   => 'nullable|string',
            'contract_type' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'end_contract_date' => 'nullable|date',
            'work_location' => 'nullable|string',
            'supervisor' => 'nullable|string',
            'employee_type' => 'nullable|string',
        ]);

        $salaryRequest = $request->validate([
            'salary_base_salary' => 'nullable|numeric',
            'salary_category'    => 'nullable|string',
            'salary_echelon'     => 'nullable|string',
            'salary_currency'    => 'nullable|string',
        ]);
        $salaryData = [
            'base_salary' => $salaryRequest['salary_base_salary'] ?? 0,
            'category'    => $salaryRequest['salary_category'] ?? null,
            'echelon'     => $salaryRequest['salary_echelon'] ?? null,
            'currency'    => $salaryRequest['salary_currency'] ?? null,
        ];

        $emergencyRequest = $request->validate([
            'emergency_relationship' => 'nullable|string',
            'emergency_full_name'    => 'nullable|string',
            'emergency_phone'        => 'nullable|string',
            'emergency_address'      => 'nullable|string',
        ]);
        $emergencyData = [
            'relationship' => $emergencyRequest['emergency_relationship'] ?? null,
            'full_name'    => $emergencyRequest['emergency_full_name'] ?? null,
            'phone'        => $emergencyRequest['emergency_phone'] ?? null,
            'address'      => $emergencyRequest['emergency_address'] ?? null,
        ];

        $childrenRequest = $request->validate([
            'children.*.full_name'     => 'nullable|string',
            'children.*.date_of_birth' => 'nullable|date',
            'children.*.gender'        => 'nullable|string',
        ]);

        $dependantsRequest = $request->validate([
            'dependants'                => 'nullable|array',
            'dependants.*.relationship' => 'nullable|string',
            'dependants.*.full_name'    => 'nullable|string',
            'dependants.*.phone'        => 'nullable|string',
            'dependants.*.address'      => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        DB::transaction(function () use ($validated, $addressData, $companyData, $salaryData, $emergencyData, $childrenRequest, $dependantsRequest) {
            $latest = Employee::latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $validated['employee_id'] = 'KAM_KIT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $validated['status'] = 1;

            $employee = Employee::create($validated);

            Address::create(array_merge($addressData, ['employee_id' => $employee->employee_id]));
            Company::create(array_merge($companyData, ['employee_id' => $employee->employee_id]));
            Salary::create(array_merge($salaryData, ['employee_id' => $employee->employee_id]));

            if (array_filter($emergencyData)) {
                Emergency::create(array_merge($emergencyData, ['employee_id' => $employee->employee_id]));
            }

            if (!empty($childrenRequest['children'])) {
                foreach ($childrenRequest['children'] as $child) {
                    Children::create([
                        'employee_id'   => $employee->employee_id,
                        'full_name'     => $child['full_name'] ?? null,
                        'date_of_birth' => $child['date_of_birth'] ?? null,
                        'gender'        => $child['gender'] ?? null,
                    ]);
                }
            }

            if (!empty($dependantsRequest['dependants'])) {
                foreach ($dependantsRequest['dependants'] as $dependant) {
                    Dependant::create([
                        'employee_id' => $employee->employee_id,
                        'relationship'=> $dependant['relationship'] ?? null,
                        'full_name'   => $dependant['full_name'] ?? null,
                        'phone'       => $dependant['phone'] ?? null,
                        'address'     => $dependant['address'] ?? null,
                    ]);
                }
            }
        });

        return redirect()
            ->route('employee.list')
            ->with('success', 'Employee created successfully!');

    }


    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {

        $employee->load('address', 'company', 'salaries', 'emergencies', 'children', 'dependants');

        return view('employee.view', compact('employee'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {

        $employee->load('address', 'company', 'salaries', 'emergencies', 'children', 'dependants');


        $departments = Department::all();
        $sections = Section::all();
        $jobTitles = JobTitle::all();

        return view('Employee.edit', compact('employee', 'departments', 'sections', 'jobTitles'));
    }



    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, Employee $employee)
//    {
//        $validated = $request->validate([
//            'first_name' => 'sometimes|string',
//            'last_name'  => 'sometimes|string',
//            'middle_name'=> 'sometimes|string',
//            'gender'     => 'sometimes|string|in:M,F',
//            'date_of_birth' => 'nullable|date',
//            'number_card'   => 'nullable|string',
//            'pays'          => 'nullable|string',
//            'marital_status'=> 'nullable|in:single,married,divorced,widowed',
//            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//        ]);
//
//        if ($request->hasFile('photo')) {
//
//            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
//                Storage::disk('public')->delete($employee->photo);
//            }
//            $validated['photo'] = $request->file('photo')->store('photos', 'public');
//        }
//
//
//        $addressData = $request->validate([
//            'address_number' => 'sometimes|string',
//            'address_city' => 'sometimes|string',
//            'address_province' => 'sometimes|string',
//            'address_phone' => 'sometimes|string',
//            'address_emergency_phone' => 'nullable|string',
//            'address_email' => 'nullable|email',
//        ]);
//
//        $companyData = $request->validate([
//            'job_title' => 'nullable|string',
//            'department' => 'nullable|string',
//            'section' => 'nullable|string',
//            'contract_type' => 'nullable|string',
//            'hire_date' => 'nullable|date',
//            'end_contract_date' => 'nullable|date',
//            'work_location' => 'nullable|string',
//            'supervisor' => 'nullable|string',
//            'employee_type' => 'nullable|string',
//        ]);
//
//        $emergencyData = $request->validate([
//            'emergency_relationship' => 'nullable|string',
//            'emergency_full_name'    => 'nullable|string',
//            'emergency_phone'        => 'nullable|string',
//            'emergency_address'      => 'nullable|string',
//        ]);
//
//        $salaryData = $request->validate([
//            'salary_base_salary' => 'nullable|numeric',
//            'salary_category'    => 'nullable|string',
//            'salary_echelon'     => 'nullable|string',
//            'salary_currency'    => 'nullable|string',
//        ]);
//
//        $childrenData = $request->validate([
//            'children' => 'nullable|array',
//            'children.*.id' => 'nullable|exists:childrens,id',
//            'children.*.child_full_name' => ' string|max:255',
//            'children.*.child_date_of_birth' => 'nullable|date',
//            'children.*.child_gender' => 'nullable|in:M,F',
//        ]);
//
//        $dependantsData = $request->validate([
//            'dependants' => 'nullable|array',
//            'dependants.*.id' => 'nullable|exists:dependants,id',
//            'dependants.*.dep_full_name' => ' string|max:255',
//            'dependants.*.dep_relationship' => 'nullable|in:Father,Mother,Spouse,Brother,Sister,Mr,Mrs,Dr',
//            'dependants.*.dep_phone' => 'nullable|string|max:20',
//            'dependants.*.dep_address' => 'nullable|string|max:255',
//        ]);
//
//
//        DB::transaction(function () use ($employee, $validated, $request, $addressData, $emergencyData, $salaryData, $companyData, $childrenData,$dependantsData) {
//
//            if (!empty($validated)) {
//                $employee->update($validated);
//            }
//
//            if (!empty($addressData)) {
//
//                $mappedAddress = [
//                    'number' => $addressData['address_number'] ?? null,
//                    'city' => $addressData['address_city'] ?? null,
//                    'province' => $addressData['address_province'] ?? null,
//                    'phone' => $addressData['address_phone'] ?? null,
//                    'emergency_phone' => $addressData['address_emergency_phone'] ?? null,
//                    'email' => $addressData['address_email'] ?? null,
//                ];
//
//                $employee->address()->updateOrCreate(
//                    ['employee_id' => $employee->employee_id],
//                    $mappedAddress
//                );
//            }
//
//            if (!empty($emergencyData)) {
//                $mappedEmergency = [
//                    'relationship' => $emergencyData['emergency_relationship'] ?? null,
//                    'full_name'    => $emergencyData['emergency_full_name'] ?? null,
//                    'phone' => $emergencyData['emergency_phone'] ?? null,
//                    'address'      => $emergencyData['emergency_address'] ?? null,
//                ];
//
//                $employee->emergencies()->updateOrCreate(
//                    ['employee_id' => $employee->employee_id],
//                    $mappedEmergency
//                );
//            }
//
//            if (!empty($salaryData)) {
//                $mappedSalary = [
//                    'base_salary' => $salaryData['salary_base_salary'] ?? null,
//                    'category'    => $salaryData['salary_category'] ?? null,
//                    'echelon'     => $salaryData['salary_echelon'] ?? null,
//                    'currency'    => $salaryData['salary_currency'] ?? null,
//                ];
//
//                $employee->salaries()->updateOrCreate(
//                    ['employee_id' => $employee->employee_id],
//                    $mappedSalary
//                );
//            }
//
//            if (!empty($companyData)) {
//                $mappedCompany = [
//                    'job_title'        => $companyData['job_title'] ?? null,
//                    'department'       => $companyData['department'] ?? null,
//                    'section'          => $companyData['section'] ?? null,
//                    'contract_type'    => $companyData['contract_type'] ?? null,
//                    'hire_date'        => $companyData['hire_date'] ?? null,
//                    'end_contract_date'=> $companyData['end_contract_date'] ?? null,
//                    'work_location'    => $companyData['work_location'] ?? null,
//                    'supervisor'       => $companyData['supervisor'] ?? null,
//                    'employee_type'    => $companyData['employee_type'] ?? null,
//                ];
//
//                $employee->company()->updateOrCreate(
//                    ['employee_id' => $employee->employee_id],
//                    $mappedCompany
//                );
//            }
//
//            if (!empty($childrenData['children'])) {
//                foreach ($childrenData['children'] as $child) {
//                    if (!empty($child['id'])) {
//
//                        $employee->children()->where('id', $child['id'])->update([
//                            'full_name' => $child['child_full_name'],
//                            'date_of_birth' => $child['child_date_of_birth'] ?? null,
//                            'gender' => $child['child_gender'] ?? null,
//                        ]);
//                    } else {
//                        $employee->children()->create([
//                            'employee_id' => $employee->employee_id,
//                            'full_name' => $child['child_full_name'],
//                            'date_of_birth' => $child['child_date_of_birth'] ?? null,
//                            'gender' => $child['child_gender'] ?? null,
//                        ]);
//                    }
//                }
//            }
//
//            if (!empty($dependantsData['dependants'])) {
//                foreach ($dependantsData['dependants'] as $dep) {
//                    if (!empty($dep['id'])) {
//                        $employee->dependants()->where('id', $dep['id'])->update([
//                            'full_name' => $dep['dep_full_name'],
//                            'relationship' => $dep['dep_relationship'] ?? null,
//                            'phone' => $dep['dep_phone'] ?? null,
//                            'address' => $dep['dep_address'] ?? null,
//                        ]);
//                    } else {
//                        $employee->dependants()->create([
//                            'full_name' => $dep['dep_full_name'],
//                            'relationship' => $dep['dep_relationship'] ?? null,
//                            'phone' => $dep['dep_phone'] ?? null,
//                            'address' => $dep['dep_address'] ?? null,
//                        ]);
//                    }
//                }
//            }
//
//
//        });
//
//        return redirect()
//            ->route('employee.list')
//            ->with('success', 'Employee updated successfully!');
//    }
//

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'nullable|string',
            'last_name'  => 'nullable|string',
            'middle_name'=> 'nullable|string',
            'gender'     => 'nullable|string|in:M,F',
            'date_of_birth' => 'nullable|date',
            'number_card'   => 'nullable|string',
            'pays'          => 'nullable|string',
            'marital_status'=> 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $addressData = $request->validate([
            'address_number' => 'nullable|string',
            'address_city' => 'nullable|string',
            'address_province' => 'nullable|string',
            'address_phone' => 'nullable|string',
            'address_emergency_phone' => 'nullable|string',
            'address_email' => 'nullable|email',
        ]);

        $companyData = $request->validate([
            'job_title' => 'nullable|string',
            'department' => 'nullable|string',
            'section' => 'nullable|string',
            'contract_type' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'end_contract_date' => 'nullable|date',
            'work_location' => 'nullable|string',
            'supervisor' => 'nullable|string',
            'employee_type' => 'nullable|string',
        ]);

        $emergencyData = $request->validate([
            'emergency_relationship' => 'nullable|string',
            'emergency_full_name'    => 'nullable|string',
            'emergency_phone'        => 'nullable|string',
            'emergency_address'      => 'nullable|string',
        ]);

        $salaryData = $request->validate([
            'salary_base_salary' => 'nullable|numeric',
            'salary_category'    => 'nullable|string',
            'salary_echelon'     => 'nullable|string',
            'salary_currency'    => 'nullable|string',
        ]);

        $childrenData = $request->validate([
            'children' => 'nullable|array',
            'children.*.id' => 'nullable|exists:childrens,id',
            'children.*.child_full_name' => 'nullable|string|max:255',
            'children.*.child_date_of_birth' => 'nullable|date',
            'children.*.child_gender' => 'nullable|in:M,F',
        ]);

        $dependantsData = $request->validate([
            'dependants' => 'nullable|array',
            'dependants.*.id' => 'nullable|exists:dependants,id',
            'dependants.*.dep_full_name' => 'nullable|string|max:255',
            'dependants.*.dep_relationship' => 'nullable|string',
            'dependants.*.dep_phone' => 'nullable|string|max:20',
            'dependants.*.dep_address' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($employee, $validated, $addressData, $emergencyData, $salaryData, $companyData, $childrenData, $dependantsData) {

            if (!empty($validated)) {
                $employee->update($validated);
            }

            if (!empty($addressData)) {
                $mappedAddress = [
                    'number' => $addressData['address_number'] ?? null,
                    'city' => $addressData['address_city'] ?? null,
                    'province' => $addressData['address_province'] ?? null,
                    'phone' => $addressData['address_phone'] ?? null,
                    'emergency_phone' => $addressData['address_emergency_phone'] ?? null,
                    'email' => $addressData['address_email'] ?? null,
                ];
                $employee->address()->updateOrCreate(
                    ['employee_id' => $employee->employee_id],
                    $mappedAddress
                );
            }

            if (!empty($emergencyData)) {
                $mappedEmergency = [
                    'relationship' => $emergencyData['emergency_relationship'] ?? null,
                    'full_name'    => $emergencyData['emergency_full_name'] ?? null,
                    'phone' => $emergencyData['emergency_phone'] ?? null,
                    'address'      => $emergencyData['emergency_address'] ?? null,
                ];
                $employee->emergencies()->updateOrCreate(
                    ['employee_id' => $employee->employee_id],
                    $mappedEmergency
                );
            }

            if (!empty($salaryData)) {
                $mappedSalary = [
                    'base_salary' => $salaryData['salary_base_salary'] ?? null,
                    'category'    => $salaryData['salary_category'] ?? null,
                    'echelon'     => $salaryData['salary_echelon'] ?? null,
                    'currency'    => $salaryData['salary_currency'] ?? null,
                ];
                $employee->salaries()->updateOrCreate(
                    ['employee_id' => $employee->employee_id],
                    $mappedSalary
                );
            }

            if (!empty($companyData)) {
                $mappedCompany = [
                    'job_title'        => $companyData['job_title'] ?? null,
                    'department'       => $companyData['department'] ?? null,
                    'section'          => $companyData['section'] ?? null,
                    'contract_type'    => $companyData['contract_type'] ?? null,
                    'hire_date'        => $companyData['hire_date'] ?? null,
                    'end_contract_date'=> $companyData['end_contract_date'] ?? null,
                    'work_location'    => $companyData['work_location'] ?? null,
                    'supervisor'       => $companyData['supervisor'] ?? null,
                    'employee_type'    => $companyData['employee_type'] ?? null,
                ];
                $employee->company()->updateOrCreate(
                    ['employee_id' => $employee->employee_id],
                    $mappedCompany
                );
            }

            if (!empty($childrenData['children'])) {
                foreach ($childrenData['children'] as $child) {
                    if (!empty($child['id'])) {
                        $employee->children()->where('id', $child['id'])->update([
                            'full_name' => $child['child_full_name'] ?? null,
                            'date_of_birth' => $child['child_date_of_birth'] ?? null,
                            'gender' => $child['child_gender'] ?? null,
                        ]);
                    } else {
                        $employee->children()->create([
                            'employee_id' => $employee->employee_id,
                            'full_name' => $child['child_full_name'] ?? null,
                            'date_of_birth' => $child['child_date_of_birth'] ?? null,
                            'gender' => $child['child_gender'] ?? null,
                        ]);
                    }
                }
            }

            if (!empty($dependantsData['dependants'])) {
                foreach ($dependantsData['dependants'] as $dep) {
                    if (!empty($dep['id'])) {
                        $employee->dependants()->where('id', $dep['id'])->update([
                            'full_name' => $dep['dep_full_name'] ?? null,
                            'relationship' => $dep['dep_relationship'] ?? null,
                            'phone' => $dep['dep_phone'] ?? null,
                            'address' => $dep['dep_address'] ?? null,
                        ]);
                    } else {
                        $employee->dependants()->create([
                            'full_name' => $dep['dep_full_name'] ?? null,
                            'relationship' => $dep['dep_relationship'] ?? null,
                            'phone' => $dep['dep_phone'] ?? null,
                            'address' => $dep['dep_address'] ?? null,
                        ]);
                    }
                }
            }

        });

        return redirect()
            ->route('employee.list')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function list()
    {
        $employees = Employee::where('status', 1)
            ->latest('id')
            ->paginate(5);


        return view('Employee.list', compact('employees'));
    }

    public function disable(Employee $employee)
    {
        $employee->update([
            'status' => 0
        ]);

        return redirect()
            ->back()
            ->with('success', 'Employee disabled successfully.');
    }

    public function search(Request $request)
    {
        $employees = Employee::where('status', 1)
            ->where(function ($query) use ($request) {
                $query->where('employee_id', 'like', '%' . $request->search . '%')
                    ->orWhere('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->search . '%');
            }) ;

        return view('Employee.partials.search-result', compact('employees'));
    }

    public function cdd()
    {
        $employees = Employee::where('status', 1)
            ->whereHas('company', function ($q) {
                $q->where('contract_type', 'CDD');
            })
            ->get();

        return view('Employee.cdd', compact('employees'));
    }

    public function cdi()
    {
        $employees = Employee::with(['company','salaries'])
            ->where('status', 1)
            ->whereHas('company', function ($q) {
                $q->where('contract_type', 'CDI');
            })
            ->get();

        return view('Employee.cdi', compact('employees'));
    }

    public function finContrat($id)
    {
        $employee = Employee::with(['company','salaries'])
            ->findOrFail($id);


        if (!$employee->company || $employee->company->contract_type !== 'CDD') {
            return redirect()->back()
                ->with('error', 'Cet employé n\'est pas sous contrat CDD.');
        }


        $endDate = $employee->company->end_contract_date;

        $daysLeft = null;

        if ($endDate) {
            $daysLeft = Carbon::now()->diffInDays(
                Carbon::parse($endDate),
                false
            );
        }

        return view('Employee.document.fin-contract', compact(
            'employee',
            'daysLeft',
            'endDate'
        ));

    }
    public function certificat($id)
    {
        $employee = Employee::with(['company','salaries'])
            ->findOrFail($id);

        return view('Employee.document.certificat', compact('employee'));

    }

    public function getSections($department_id)
    {
        $sections = Section::where('department_id', $department_id)->get();
        return response()->json($sections);
    }

    public function getJobTitles($section_id)
    {
        $jobTitles = JobTitle::where('section_id', $section_id)->get();
        return response()->json($jobTitles);
    }

    public function file()
    {
        return view('Employee.file');
    }


}
