@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="min-h-screen p-10 max-w-2xl mx-auto">
    <h1 class="font-black text-3xl text-center mb-6">{{ $title }}</h1>

    {{-- Info Tugas --}}
    <a href="{{ route('tasks.index') }}" class="font-black bg-gray-300 p-2 rounded-xl">Kembali</a>
    <div class="bg-gray-100 rounded-2xl p-6 mb-6 mt-6">
        <p><strong>Judul:</strong> {{ $task->title }}</p>
        <p><strong>Departemen:</strong> {{ $task->department->name }}</p>
        <p><strong>Area:</strong> {{ $task->area->name }}</p>
        <p><strong>Deadline:</strong> {{ $task->due_at }}</p>
        <p><strong>Status:</strong> {{ $submission->status ?? 'Belum Dikumpul' }}</p>
    </div>

    {{-- Form --}}
    <form action="{{ route('tasks.collect.store', $task->id) }}" method="POST" class="bg-white border p-6">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Link Google Drive</label>
            <input type="url" name="link_drive"
                   value="{{ old('link_drive', $submission->link_drive ?? '') }}"
                   class="w-full border px-3 py-2"
                   placeholder="https://drive.google.com/...">
            @error('link_drive')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Catatan (Opsional)</label>
            <textarea name="note" rows="4" class="w-full border px-3 py-2">{{ old('note', $submission->note ?? '') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            Kumpul
        </button>
    </form>
</div>
@endsection