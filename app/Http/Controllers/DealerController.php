<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealerController extends Controller
{
    

    public function index(Request $request){

        $title = "Halaman Dealers";

        return view('dealers.index', [
            'title' => $title
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Dealer';

        return view('dealers.create', [
            'title'=> $title
        ]);
    }

    public function show(){
        $title = 'Halaman Detail Dealer';

        return view('dealers.show', [
            'title' => $title
        ]);
    }

    public function edit(){
        $title = 'Halaman Edit Dealer';
        
        return view('dealers.edit', [
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
