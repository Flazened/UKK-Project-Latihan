@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="min-h-screen p-10 py-10">
        <h1 class="font-black text-3xl flex justify-center">{{ $title }}</h1>
        <div class="flex justify-between">
            <div class="mb-10 flex justify-center p-5 rounded-3xl border-[1px] bg-black h-auto w-auto">
                <button>
                    <a href="" class="text-white font-black">Periksa Tugas</a>
                </button>
            </div>
            <div class="mb-10 flex justify-center p-5 rounded-3xl border-[1px] bg-black h-auto w-auto">
                <button>
                    <a href="{{ route('tasks.create') }}" class="text-white font-black">Tambah</a>
                </button>
            </div>
        </div>
        <div class="bg-gray-100 rounded-3xl shadow-2xl">
            <table class=" w-full text-left">

                <thead>
                    <tr class="py-5 bg-gray-400 rounded-3xl">
                        <th class="px-2 text-xl">No</th>
                        <th class="px-2 text-xl">Title</th>
                        <th class="px-2 text-xl">Department</th>
                        <th class="px-2 text-xl">Area</th>
                        <th class="px-2 text-xl">Tenggat Waktu</th>
                        <th class="px-2 text-xl">Pembuat Tugas</th>
                        <th class="px-2 text-xl py-3 flex justify-end mr-25">Aksi</th>
                    </tr>
                </thead>



@endsection