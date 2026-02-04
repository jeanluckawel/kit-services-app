<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Section;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    public function index()
    {

        $departments = Department::with('sections.jobTitles')->paginate(5);

        return view('organization.index', compact('departments'));
    }


    public function create()
    {
        $departments = Department::all();
        $sections = Section::all();
        return view('organization.create', compact('departments','sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string',
            'section' => 'required|string',
            'jobtitle' => 'required|string',
        ]);


        $department = Department::firstOrCreate(['name' => $request->department]);


        $section = Section::firstOrCreate([
            'name' => $request->section,
            'department_id' => $department->id
        ]);


        JobTitle::firstOrCreate([
            'name' => $request->jobtitle,
            'section_id' => $section->id
        ]);

        return redirect()->route('org.index')->with('success', 'Organisation saved successfully.');
    }


}
