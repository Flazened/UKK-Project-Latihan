@extends('layouts.app')

@section('title', $title)

@section('content')
    {{-- Isi Konten --}}
    
    <div class="min-h-screen p-10 py-10">
        <h1 class="font-black text-3xl flex justify-center">{{ $title }}</h1>
        <div class="flex justify-end">
            <div class="mb-10 flex justify-center p-5 rounded-3xl border-[1px] bg-black h-auto w-auto">
                <button>
                    <a href="{{ route('dealers.create') }}" class="text-white font-black">Tambah</a>
                </button>
            </div>
        </div>
        <div class="bg-gray-100 rounded-3xl shadow-2xl">
            <table class=" w-full text-left">

                <thead>
                    <tr class="py-5 bg-gray-400 rounded-3xl">
                        <th class="px-2 text-xl">No</th>
                        <th class="px-2 text-xl">Code</th>
                        <th class="px-2 text-xl">Name</th>
                        <th class="px-2 text-xl py-3 flex justify-end mr-25">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dealers as $dealer)
                        
                    
                    <tr class="rounded-3xl">
                        <td class="px-4 text-2xl font-black">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-2">
                            {{ $dealer->code }}
                        </td>
                        <td class="px-2">
                            {{ $dealer->name }}
                        </td>
                        <td class="flex gap-2 justify-end px-2 py-2">
                            <a href="{{ route('dealers.show', ['dealer' => $dealer->id]) }}" class="bg-blue-400 font-black text-white px-4 py-2 rounded-md">Detail</a>
                            <a href="{{ route('dealers.edit', ['dealer' => $dealer->id]) }}" class="bg-yellow-400 font-black text-white px-4 py-2 rounded-md">Edit</a>

                            <form method="POST" class="inline" 
                                onsubmit="return confirm('Hapus data siswa ini dari buku induk?')"
                                action="{{ route('dealers.destroy', ['dealer' => $dealer->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-400 font-black text-white px-4 py-2 rounded-md">Delete</button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 py-2">Data pada {{ $title }} tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
    
@endsection