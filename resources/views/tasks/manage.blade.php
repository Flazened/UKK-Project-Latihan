@extends('layouts.app')

@section('title', $title)

@section('content')

    <div class="flex justify-center p-20">
        <div class="space-y-5">

            <div>
                <a href="{{ route('tasks.index') }}">Kembali</a>
            </div>
            <!-- ===================== -->
            <!-- INFORMASI LAPORAN -->
            <!-- ===================== -->
            <div class="border border-gray-200 rounded-md p-4 bg-gray-50">
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="text-gray-500 mb-1">Nama Laporan</dt>
                        <dd class="font-medium text-gray-900">Laporan Penjualan Bulan Oktober</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500 mb-1">Nama Dealer</dt>
                        <dd class="font-medium text-gray-900">Dealer Maju Jaya</dd>
                    </div>

                    <div>
                        <dt class="text-gray-500 mb-1">Tanggal Kumpul</dt>
                        <dd class="font-medium text-gray-900">09 Oktober 2026</dd>
                    </div>

                    <div class="sm:col-span-3">
                        <dt class="text-gray-500 mb-1">Link Google Drive</dt>
                        <dd>
                            <a href="#" target="_blank"
                                class="text-sm font-medium text-gray-900 underline underline-offset-2 hover:text-gray-600 break-all">
                                https://drive.google.com/drive/folders/xxxxxx
                            </a>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- ===================== -->
            <!-- FORM PEMERIKSAAN -->
            <!-- ===================== -->
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <!-- Status Pengumpulan -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Status Pengumpulan
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-3 px-4 py-3 border border-gray-300 rounded-md cursor-pointer
                                  hover:border-black has-[:checked]:border-black has-[:checked]:bg-gray-50">
                            <input type="radio" name="status" value="DISETUJUI" class="accent-black">
                            <span class="text-sm font-medium">DISETUJUI</span>
                        </label>

                        <label class="flex items-center gap-3 px-4 py-3 border border-gray-300 rounded-md cursor-pointer
                                  hover:border-black has-[:checked]:border-black has-[:checked]:bg-gray-50">
                            <input type="radio" name="status" value="REVISI" class="accent-black">
                            <span class="text-sm font-medium">REVISI</span>
                        </label>

                        <label class="flex items-center gap-3 px-4 py-3 border border-gray-300 rounded-md cursor-pointer
                                  hover:border-black has-[:checked]:border-black has-[:checked]:bg-gray-50">
                            <input type="radio" name="status" value="DITOLAK" class="accent-black">
                            <span class="text-sm font-medium">DITOLAK</span>
                        </label>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-900 mb-1.5">
                        Catatan
                    </label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Tuliskan catatan untuk dealer..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md
                                 focus:outline-none focus:border-black focus:ring-1 focus:ring-black resize-none"></textarea>
                </div>

                <!-- Tombol -->
                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto px-6 bg-black text-white text-sm font-medium py-2.5 rounded-md
                               hover:bg-gray-800 transition-colors">
                        Simpan Pemeriksaan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection