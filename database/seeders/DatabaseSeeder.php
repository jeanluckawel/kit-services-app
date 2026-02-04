<?php

namespace Database\Seeders;


use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        $this->call([
            PermissionSeeder::class,
            CustomerSeeder::class,
        ]);


        $departments = [
            'Finance',
            'Human Resources',
            'IT',
            'Operations',
            'Marketing'
        ];

        foreach ($departments as $deptName) {
            $department = Department::create(['name' => $deptName]);

            $sections = match($deptName) {
                'Finance' => ['Accounting', 'Audit', 'Payroll'],
                'Human Resources' => ['Recruitment', 'Training', 'Employee Relations'],
                'IT' => ['Development', 'Support', 'Network'],
                'Operations' => ['Logistics', 'Production', 'Maintenance'],
                'Marketing' => ['Advertising', 'Social Media', 'Research'],
                default => ['General']
            };

            foreach ($sections as $secName) {
                $section = Section::create([
                    'name' => $secName,
                    'department_id' => $department->id
                ]);

                $jobTitles = match($secName) {
                    'Accounting' => ['Accountant', 'Senior Accountant'],
                    'Audit' => ['Auditor', 'Senior Auditor'],
                    'Payroll' => ['Payroll Officer', 'Payroll Manager'],
                    'Recruitment' => ['Recruiter', 'Recruitment Manager'],
                    'Training' => ['Trainer', 'HR Trainer'],
                    'Employee Relations' => ['HR Officer', 'HR Specialist'],
                    'Development' => ['Developer', 'Senior Developer'],
                    'Support' => ['IT Support', 'Helpdesk Technician'],
                    'Network' => ['Network Engineer', 'Network Admin'],
                    'Logistics' => ['Logistics Officer', 'Logistics Manager'],
                    'Production' => ['Production Operator', 'Production Supervisor'],
                    'Maintenance' => ['Maintenance Technician', 'Maintenance Manager'],
                    'Advertising' => ['Marketing Assistant', 'Advertising Manager'],
                    'Social Media' => ['Social Media Manager', 'Content Creator'],
                    'Research' => ['Market Analyst', 'Research Manager'],
                    default => ['Employee']
                };

                foreach ($jobTitles as $jobName) {
                    JobTitle::create([
                        'name' => $jobName,
                        'section_id' => $section->id
                    ]);
                }
            }
        }

    }
}
