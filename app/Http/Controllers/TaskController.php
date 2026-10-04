<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request){

        $title = "Halaman Tugas";

        return view('tasks.index', [
            'title' => $title
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Tugas';

        return view('tasks.create', [
            'title'=> $title
        ]);
    }

    public function show(){
        $title = 'Halaman Detail Tugas';

        return view('tasks.show', [
            'title' => $title
        ]);
    }

    public function edit(){
        $title = 'Halaman Edit Tugas';
        
        return view('tasks.edit', [
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
