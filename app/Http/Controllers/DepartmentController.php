<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index(){

        $title = "Halaman Departemen";
        $departments = Department::select('id','name', 'code')->get();


        return view('departments.index', [
            'title' => $title,
            'departments' => $departments
        ]);
    }

    public function show(Department $department){
        $title = 'Halaman Detail Department';

        return view('departments.show', [
            'title' => $title,
            'department' => $department
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Department';

        return view('departments.create', [
            'title'=> $title
        ]);
    }


    public function edit(Department $department){
        $title = 'Halaman Edit Department';
        
        return view('departments.edit', [
            'title' => $title,
            'department' => $department
        ]);
    }

    public function store(Request $request ){
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:departments,code'],
        ]);

        Department::create($validatedRequest);

        return redirect()->route('departments.index')
            ->with('succes', 'Department Berhasil Ditambahkan');


        
    }

    public function update(Department $department , Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:departments,code,' . $department->id],
        ]);

        $department->update( $validatedRequest);
        
        return redirect()->route('departments.index')
            ->with('succes','Berhasil Mengubah data Department');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index');

    }
}
