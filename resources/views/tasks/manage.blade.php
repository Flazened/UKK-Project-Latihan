@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="min-h-screen p-10 max-w-6xl mx-auto">

    <a href="{{ route('tasks.index') }}" class="font-black bg-gray-300 p-2 rounded-xl">Kembali</a>

    {{-- Info Tugas --}}
    <div class="bg-gray-100 rounded-2xl p-6 my-6">
        <h1 class="font-black text-3xl mb-4">{{ $title }}</h1>
        <p><strong>Judul Tugas:</strong> {{ $task->title }}</p>
        <p><strong>Departemen:</strong> {{ $task->department->name }}</p>
        <p><strong>Area:</strong> {{ $task->area->name }}</p>
        <p><strong>Deadline:</strong> {{ $task->due_at }}</p>
    </div>

    {{-- Daftar Submission --}}
    @if ($submissions->count())
        <div class="space-y-6">
            @foreach ($submissions as $submission)
                <div class="bg-white border rounded-2xl p-6">

                    {{-- Info Submission --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-4">
                        <div>
                            <dt class="text-gray-500">Dealer</dt>
                            <dd class="font-medium">{{ $submission->dealer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal Kumpul</dt>
                            <dd class="font-medium">
                                {{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd class="font-medium">{{ $submission->status }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-gray-500">Link Google Drive</dt>
                            <dd>
                                <a href="{{ $submission->link_drive }}" target="_blank"
                                   class="text-blue-600 underline break-all">
                                    {{ $submission->link_drive }}
                                </a>
                            </dd>
                        </div>
                        @if ($submission->note)
                            <div class="sm:col-span-3">
                                <dt class="text-gray-500">Catatan Dealer</dt>
                                <dd>{{ $submission->note }}</dd>
                            </div>
                        @endif
                    </div>

                    {{-- Form Review --}}
                    <form action="{{ route('tasks.review', $submission->id) }}" method="POST"
                          class="border-t pt-4 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium mb-2">Status Pengumpulan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="flex items-center gap-3 px-4 py-3 border rounded-md cursor-pointer">
                                    <input type="radio" name="status" value="DISETUJUI"
                                        {{ $submission->status === 'DISETUJUI' ? 'checked' : '' }}>
                                    <span class="text-sm">DISETUJUI</span>
                                </label>
                                <label class="flex items-center gap-3 px-4 py-3 border rounded-md cursor-pointer">
                                    <input type="radio" name="status" value="REVISI"
                                        {{ $submission->status === 'REVISI' ? 'checked' : '' }}>
                                    <span class="text-sm">REVISI</span>
                                </label>
                                <label class="flex items-center gap-3 px-4 py-3 border rounded-md cursor-pointer">
                                    <input type="radio" name="status" value="DITOLAK"
                                        {{ $submission->status === 'DITOLAK' ? 'checked' : '' }}>
                                    <span class="text-sm">DITOLAK</span>
                                </label>
                            </div>
                            @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Catatan Supervisor</label>
                            <textarea name="catatan" rows="3"
                                class="w-full border px-3 py-2 text-sm rounded-md">{{ old('catatan', $submission->supervisor_note) }}</textarea>
                            @error('catatan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                            class="bg-black text-white text-sm px-6 py-2 rounded-md">
                            Simpan Pemeriksaan
                        </button>
                    </form>

                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-100 rounded-2xl p-6 text-center">
            Belum ada dealer yang mengumpulkan tugas ini.
        </div>
    @endif

</div>
@endsection