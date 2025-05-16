<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return Inertia::render('Department/Index', [
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Department/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'ป้อนข้อมูลชื่อแผนกด้วย'
        ]);

        Department::create($request->all());

        return to_route('department.index')->with('message','เพิ่มข้อมูลสำเร็จ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::find($id);
        return Inertia::render('Department/Edit', [
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'ป้อนข้อมูลชื่อแผนกด้วย'
        ]);

        $department = Department::find($id);
        $department->update($request->all());

        return to_route('department.index')->with('message','แก้ไขข้อมูลสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $department = Department::find($request->id);
        $department->delete();

        return to_route('department.index')->with('message','ลบข้อมูลสำเร็จ');
    }
}
