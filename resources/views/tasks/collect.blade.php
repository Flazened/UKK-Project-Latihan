@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="min-h-screen p-10 max-w-2xl mx-auto">
    <h1 class="font-black text-3xl text-center mb-6">{{ $title }}</h1>

    <a href="{{ route('tasks.index') }}" class="font-black bg-gray-300 p-2 rounded-xl">Kembali</a>

    {{-- Info Tugas --}}
    <div class="bg-gray-100 rounded-2xl p-6 mb-6 mt-6">
        <p><strong>Judul:</strong> {{ $task->title }}</p>
        <p><strong>Departemen:</strong> {{ $task->department->name }}</p>
        <p><strong>Area:</strong> {{ $task->area->name }}</p>
        <p><strong>Deadline:</strong> {{ $task->due_at }}</p>
        <p><strong>Status:</strong> {{ $submission->status ?? 'Belum Dikumpul' }}</p>
    </div>

    {{-- Catatan supervisor (kalau ada) --}}
    @if ($submission && $submission->supervisor_note)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-6">
            <p class="font-semibold">Catatan Supervisor:</p>
            <p>{{ $submission->supervisor_note }}</p>
        </div>
    @endif

    {{-- Form / Pesan --}}
    @if ($bolehSubmit)
        <form action="{{ route('tasks.collect.store', $task->id) }}" method="POST" class="bg-white border p-6">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Link Google Drive</label>
                <input type="text" name="link_drive"
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
                {{ $submission ? 'Kumpul Ulang' : 'Kumpul' }}
            </button>
        </form>
    @else
        <div class="bg-red-100 border-l-4 border-red-500 p-4">
            @if ($statusFinal)
                <p class="font-semibold">Tugas sudah {{ $submission->status }}.</p>
                <p>Tidak bisa mengumpulkan lagi.</p>
            @elseif ($deadlineLewat)
                <p class="font-semibold">Deadline sudah lewat.</p>
                <p>Tidak bisa mengumpulkan lagi.</p>
            @endif
        </div>
    @endif

    {{-- Tabel Log --}}
    @if ($submission && $submission->logs->count())
        <div class="mt-8">
            <h2 class="font-bold text-xl mb-3">Riwayat Pengumpulan</h2>
            <div class="bg-gray-100 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Aktivitas</th>
                            <th class="px-4 py-2">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    @if ($log->activity === 'KUMPUL')
                                        <span class="bg-blue-200 px-2 py-1 rounded text-xs">Kumpul</span>
                                    @elseif ($log->activity === 'PENGUMPULAN_ULANG')
                                        <span class="bg-yellow-200 px-2 py-1 rounded text-xs">Pengumpulan Ulang</span>
                                    @elseif ($log->activity === 'REVIEW')
                                        <span class="bg-green-200 px-2 py-1 rounded text-xs">Review</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $log->note ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection