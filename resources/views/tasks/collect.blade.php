@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="min-h-screen p-10">
    <h1 class="font-black text-3xl text-center mb-6">{{ $title }}</h1>

    {{-- Info Tugas --}}
    <div class="bg-gray-100 rounded-2xl shadow-xl p-6 max-w-2xl mx-auto mb-6">
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Nama Laporan:</span><span class="font-semibold">{{ $task->title }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Departemen:</span><span class="font-semibold">{{ $task->department->name }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Area:</span><span class="font-semibold">{{ $task->area->name }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Deadline:</span><span class="font-semibold">{{ $task->due_at }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Status:</span>
            <span class="font-semibold">{{ $submission?->status ?? 'Belum Dikumpul' }}</span>
        </div>
    </div>

    {{-- Form Pengumpulan --}}
    @if (!$submission || $submission->canBeResubmitted())
    <form action="{{ route('tasks.collect.store', $task->id) }}" method="POST"
          class="bg-white border p-6 max-w-2xl mx-auto mb-6">
        @csrf
        <div class="mb-4">
            <label class="block text-xs font-semibold uppercase mb-1">Link Google Drive</label>
            <input type="url" name="link_drive" value="{{ old('link_drive', $submission->link_drive ?? '') }}"
                   class="w-full border px-3 py-2" placeholder="https://drive.google.com/...">
            @error('link_drive')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-xs font-semibold uppercase mb-1">Catatan (Opsional)</label>
            <textarea name="note" rows="4" class="w-full border px-3 py-2">{{ old('note', $submission->note ?? '') }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
            {{ $submission ? 'Kumpul Ulang' : 'Kumpulkan' }}
        </button>
    </form>
    @else
        <p class="text-center text-red-600 font-semibold mb-6">
            Tugas sudah {{ $submission->status }} — tidak bisa dikumpulkan lagi.
        </p>
    @endif

    {{-- Log Aktivitas --}}
    <div class="max-w-2xl mx-auto bg-gray-100 rounded-2xl shadow-xl p-6">
        <h2 class="font-bold text-lg mb-4">Log Aktivitas</h2>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-300">
                <tr><th class="p-2">Tanggal</th><th class="p-2">Aktivitas</th><th class="p-2">Catatan</th></tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr class="border-b">
                    <td class="p-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-2">{{ $log->activity }}</td>
                    <td class="p-2">{{ $log->note ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="p-2 text-center">Belum ada aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection