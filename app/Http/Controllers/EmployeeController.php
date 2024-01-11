<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'asc')->paginate(2);

        return view('index', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees,email|email',
            'phone' => 'required|numeric|unique:employees,phone',
            'joining_date' => 'required',
            'salary' => 'required',
            'is_active' => 'required'
        ], [
            'phone.unique' => 'Phone number already exist'
        ]);

        //$data = $request->except('_token');
        // Mass assigment
        Employee::create($request->except('_token'));

        // Insert Single row
        //    $employee = new Employee;
        //    $employee->name = $data['name'];
        //    $employee->email = $data['email'];
        //    $employee->joining_date = $data['joining_date'];
        //    $employee->salary = $data['salary'];
        //    $employee->phone = $data['phone'];
        //    $employee->is_active = $data['is_active'];
        //    $employee->save();

        //    dd('Success');
        return redirect()->route('employee.index')->withSuccess('Employee has been created successfully!');
        // return view('index',compact('employees'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        // $employee = Employee::find($id);
        return view('edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|numeric|unique:employees,phone,' . $employee->id,
            'joining_date' => 'required|date',
            'salary' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        $employee->update($data);

        return redirect()->route('employee.index')->withSuccess('Employee details updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')
            ->withSuccess('Employee deleted successfully');
    }

    public function toggleStatus(Employee $employee)
    {
        $employee->update(['is_active' => !$employee->is_active]);

        return redirect()->back();
    }
}
