<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreaController extends Controller
{
    
    public function index(Request $request){

        $title = "Halaman Area";

        return view('areas.index', [
            'title' => $title
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Area';

        return view('areas.create', [
            'title'=> $title
        ]);
    }

    public function show(){
        $title = 'Halaman Detail Area';

        return view('areas.show', [
            'title' => $title
        ]);
    }

    public function edit(){
        $title = 'Halaman Edit Area';
        
        return view('areas.edit', [
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
