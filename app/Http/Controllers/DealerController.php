<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\Request;

class DealerController extends Controller
{


    public function index()
    {

        $title = "Halaman Dealers";
        $dealers = Dealer::select('id', 'name', 'code')->get();
        $users = User::orderBy('name')->get();


        return view('dealers.index', [
            'title' => $title,
            'dealers' => $dealers,
            'users' => $users
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

    public function destroy(Dealer $dealer, Request $request)
    {
        // 1. Keamanan: Pastikan hanya Supervisor yang boleh menghapus
        if ($request->user()->role !== 'supervisor') {
            abort(403, 'Hanya supervisor yang dapat menghapus data dealer.');
        }
    
        // 2. Hapus User terlebih dahulu (Parent)
        // Karena ada foreign key constraint, user harus dihapus sebelum dealer
        // atau gunakan cascade delete jika sudah dikonfigurasi di migration
        if ($dealer->user) {
            $dealer->user->delete();
        }
    
        // 3. Baru hapus record Dealer
        $dealer->delete();
    
        // 4. Redirect dengan pesan sukses
        return redirect()->route('dealers.index')
            ->with('success', 'Data dealer dan akun terkait berhasil dihapus.');
    }
}
