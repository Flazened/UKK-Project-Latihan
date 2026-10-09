@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="min-h-screen p-10">
    <h1 class="font-black text-3xl text-center mb-6">{{ $title }} — {{ $task->title }}</h1>

    @forelse ($submissions as $submission)
    <div class="bg-gray-100 rounded-2xl shadow-xl p-6 max-w-3xl mx-auto mb-6">
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Nama Dealer:</span><span class="font-semibold">{{ $submission->dealer->name }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Tanggal Kumpul:</span><span class="font-semibold">{{ $submission->submitted_at?->format('d/m/Y H:i') }}</span></div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Link Drive:</span>
            <a href="{{ $submission->link_drive }}" target="_blank" class="text-blue-600 underline">Buka</a>
        </div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Status:</span>
            <span class="font-semibold">{{ $submission->status }}</span>
        </div>
        <div class="flex justify-between py-2"><span class="text-xs uppercase">Catatan Dealer:</span>
            <span>{{ $submission->note ?? '-' }}</span>
        </div>

        {{-- Form Review --}}
        <form action="{{ route('tasks.review', $submission->id) }}" method="POST" class="mt-4 border-t pt-4">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-semibold uppercase mb-1">Status</label>
                <select name="status" class="w-full border px-3 py-2">
                    <option value="DISETUJUI" @selected($submission->status === 'DISETUJUI')>DISETUJUI</option>
                    <option value="REVISI" @selected($submission->status === 'REVISI')>REVISI</option>
                    <option value="DITOLAK" @selected($submission->status === 'DITOLAK')>DITOLAK</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold uppercase mb-1">Catatan Supervisor</label>
                <textarea name="supervisor_note" rows="3" class="w-full border px-3 py-2">{{ $submission->supervisor_note }}</textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Simpan Pemeriksaan</button>
        </form>

        {{-- Log --}}
        <div class="mt-4">
            <h3 class="font-bold mb-2">Log Aktivitas</h3>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-300">
                    <tr><th class="p-2">Tanggal</th><th class="p-2">Aktivitas</th><th class="p-2">Catatan</th></tr>
                </thead>
                <tbody>
                    @foreach ($submission->logs()->latest()->get() as $log)
                    <tr class="border-b">
                        <td class="p-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-2">{{ $log->activity }}</td>
                        <td class="p-2">{{ $log->note ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <p class="text-center">Belum ada pengumpulan untuk tugas ini.</p>
    @endforelse
</div>
@endsection