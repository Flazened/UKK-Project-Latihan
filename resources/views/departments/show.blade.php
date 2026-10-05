@extends('layouts.app')

@section('title', $title)


@section('content')




<div class="min-h-screen">
    <div class="flex justify-center p-5">
        <p class="font-bold text-3xl">{{ $title }}</p>
    </div>
    <div class="flex justify-center">
        <div class="rounded-3xl shadow-2xl bg-gray-100 h-auto w-200">
                            <div class="flex justify-between px-8 py-4"> 
                            
                        <dt class="uppercase tracking-[0.1em] text-xs text-slate-800">Code Departemen :</dt> 
                            
                        <dd class="font-medium text-[#16213A]">1234</dd> 
                            
                    </div> 
                
                    <div class="flex justify-between px-8 py-4"> 
                    
                        <dt class="uppercase tracking-[0.1em] text-xs text-slate-800">Nama Departemen :</dt> 
                    
                        <dd class="font-medium text-[#16213A]">Akuntansi</dd> 
                    </div> 
                    <div class="flex justify-end gap-3 p-6">
                    <a href="{{ route('dealers.index') }}" class="bg-blue-400 h-auto font-bold w-auto p-2 rounded-lg text-white">Kembali</a>
                    <a href="{{ route('dealers.edit', 1) }}" class="bg-gray-400 h-auto font-bold w-auto p-2 rounded-lg text-white">Edit</a>
                </div>
        </div>
    </div>
</div>












@endsection