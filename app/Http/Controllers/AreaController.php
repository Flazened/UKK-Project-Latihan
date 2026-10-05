<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Dealer;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    
    public function index(Request $request){

        $title = "Halaman Area";
        $areas = Area::select('id', 'code', 'name')->get();

        return view('areas.index', [
            'title' => $title,
            'areas' => $areas
        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Area';

        return view('areas.create', [
            'title'=> $title
        ]);
    }

    public function show(Area $area){
        $title = 'Halaman Detail Area';

        return view('areas.show', [
            'title' => $title,
            'area' => $area
        ]);
    }

    public function edit(Area $area){
        $title = 'Halaman Edit Area';
        
        return view('areas.edit', [
            'title' => $title,
            'area' => $area

        ]);
    }

    public function store(Request $request){
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:areas,code'],
        ]);

        Area::create($validatedRequest);

        return redirect()->route('areas.index')
            ->with('Succes', 'Area Berhasil Dibuat');
    }

    public function update(Area $area, Request $request){
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:areas,code,' . $area->id]
        ]);

        $area->update($validatedRequest);

        return redirect()->route('areas.index')
            ->with('Succes', 'Area Berhasil Diubah');
    }

    public function destroy(Area $area){
        $area->delete();

        return redirect()->route('areas.index')
            ->with('Succes', 'Area Berhasil dihapus');
        
    }
}
