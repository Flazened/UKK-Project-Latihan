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
                    <tr class="rounded-3xl">
                        <td class="px-2 font-black">
                            1
                        </td>
                        <td class="px-2">
                            1001
                        </td>
                        <td class="px-2">
                            Sudirman Joko Spendi
                        </td>
                        <td class="flex gap-2 justify-end px-2 py-2">
                            <a href="{{ route('dealers.show', 1) }}" class="bg-blue-400 font-black text-white px-4 py-2 rounded-md">Detail</a>
                            <a href="{{ route('dealers.edit', 1) }}" class="bg-yellow-400 font-black text-white px-4 py-2 rounded-md">Edit</a>
                            <form action="{{ route('dealers.destroy', 1) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-400 font-black text-white px-4 py-2 rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
    
@endsection