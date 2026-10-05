@extends('layouts.app')

@section('title', $title)


@section('content')




<div class="min-h-screen">
    <div class="flex justify-center  p-5">
        <p class="font-bold text-3xl">{{ $title }}</p>
    </div>
    <div class="flex justify-center">
        <div class="rounded-3xl shadow-2xl bg-gray-100 h-auto w-200">
            <form action="{{ route('departments.update', ['department' => $department->id]) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="py-5">
                    <label for="code" class="ml-2 mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Code department</label>
                    <input value="{{ old('code', $department->code) }}" type="text" name="code" id="code" 
                    class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm placeholder:text-slate-400 focus:border-[#A16207] focus:bg-white focus:outline-none">
                    @error('code')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="py-5">
                    <label for="name" class="ml-2 mb-1.5 block text-xs font-semibold uppercase tracking-[0.1em] text-[#16213A]">Nama department</label>
                    <input value="{{ old('name', $department->name) }}" type="text" name="name" id="name" 
                    class="w-full border border-[#D9D6CD] bg-[#FCFBF8] px-3.5 py-2.5 text-sm placeholder:text-slate-400 focus:border-[#A16207] focus:bg-white focus:outline-none">
                    @error('name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('departments.index') }}" class="bg-red-500 h-auto w-auto p-2 rounded-lg text-white">Batal</a>
                    <button type="submit" class="bg-blue-500 h-auto w-auto p-2 rounded-lg text-white font-bold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>













@endsection