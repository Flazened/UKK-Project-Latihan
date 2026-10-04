<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
        public function index(Request $request){

        $title = "Halaman Departemen";

        return view('departments.index', [
            'title' => $title
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Departemen';

        return view('departments.create', [
            'title'=> $title
        ]);
    }

    public function show(){
        $title = 'Halaman Detail Departemen';

        return view('departments.show', [
            'title' => $title
        ]);
    }

    public function edit(){
        $title = 'Halaman Edit Departemen';
        
        return view('departments.edit', [
            'title' => $title
        ]);
    }

    public function store(){

    }

    public function update(){

    }

    public function destory(){
        
    }
}
