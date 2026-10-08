<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{


    public function index()
    {

        $title = "Halaman Dealers";
        $dealers = Dealer::select('id', 'name', 'code')->get();


        return view('dealers.index', [
            'title' => $title,
            'dealers' => $dealers
        ]);
    }

    public function show(Dealer $dealer)
    {
        $title = 'Halaman Detail Dealer';

        return view('dealers.show', [
            'title' => $title,
            'dealer' => $dealer
        ]);
    }

    public function create()
    {

        $title = 'Halaman Tambah Dealer';

        return view('dealers.create', [
            'title' => $title
        ]);
    }


    public function edit(Dealer $dealer)
    {
        $title = 'Halaman Edit Dealer';

        return view('dealers.edit', [
            'title' => $title,
            'dealer' => $dealer
        ]);
    }

    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:dealers,code'],
        ]);

        Dealer::create($validatedRequest);

        return redirect()->route('dealers.index')
            ->with('succes', 'Dealer Berhasil Ditambahkan');
    }

    public function update(Dealer $dealer, Request $request)
    {
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:dealers,code,' . $dealer->id],
        ]);

        $dealer->update($validatedRequest);

        return redirect()->route('dealers.index')
            ->with('succes', 'Berhasil Mengubah data Dealer');
    }

    public function destroy(Dealer $dealer)
    {
        $dealer->delete();

        return redirect()->route('dealers.index');
    }
}
