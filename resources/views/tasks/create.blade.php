@extends('layouts.app')

@section('title', $title)


@section('content')

<div class="min-h-screen">
    <div class="flex justify-center  p-5">
        <p class="font-bold text-3xl">{{ $title }}</p>
    </div>
    <div class="flex justify-center">
        <div class="rounded-3xl shadow-2xl bg-gray-100 h-auto w-200">

            <form action="{{ route('tasks.store') }}" method="POST" class="p-6">
                @csrf
                <div class="py-5">
                    <label for="title" class="ml-2 mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Judul Tugas</label>
                    <input value="{{ old('title') }}" type="text" name="title" id="title" placeholder="Contoh: Jual 100.000 unit mobil dalam 1 hari"
                    class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm placeholder:text-slate-400 focus:border-[#A16207] focus:bg-white focus:outline-none">
                    @error('title')
                        <span class="text-red-500 py-2">{{ $message }}</span>
                    @enderror
                </div>



                <div class="py-5"> 
                    <label for="department_id" 
                        class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Departemen</label> 
                    <select id="department_id" name="department_id"
                        class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm focus:border-[#A16207] focus:bg-white focus:outline-none"> 
                        <option value="">Pilih departemen</option> 
                        @foreach ($departments as $department)
                            <option @selected(old('department_id') === $department->id ) value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select> 
                    @error('task_id')
                            <span class="text-red-500 py-2">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="py-5"> 
                    <label for="area_id" 
                        class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Area</label> 
                    <select id="area_id" name="area_id"
                        class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm focus:border-[#A16207] focus:bg-white focus:outline-none"> 
                        <option value="">Pilih area</option> 
                        @foreach ($areas as $area)
                            <option @selected(old('area_id') === $area->id ) value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select> 
                    @error('task_id')
                            <span class="text-red-500 py-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="due_at" class="block text-gray-700 font-bold mb-2">
                        Batas Waktu (Due Date)
                    </label>

                    <input 
                        type="date" 
                        name="due_at" 
                        id="due_at"
                        {{-- Jika ada error/old data pakai itu, jika tidak pakai tanggal hari ini --}}
                        value="{{ old('due_at', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                    @error('due_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="py-5">
                    <label for="asigner" class="ml-2 mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Pembuat Tugas</label>
                    <input value="{{ old('asigner') }}" type="text" name="asigner" id="asigner" placeholder="Jane Doe"
                    class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm placeholder:text-slate-400 focus:border-[#A16207] focus:bg-white focus:outline-none">
                    @error('asigner')
                        <span class="text-red-500 py-2">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="flex justify-end gap-3">
                    <a href="{{ route('tasks.index') }}" class="bg-red-500 h-auto w-auto p-2 rounded-lg text-white">Batal</a>
                    <button type="submit" class="bg-blue-500 h-auto w-auto p-2 rounded-lg text-white font-bold">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection