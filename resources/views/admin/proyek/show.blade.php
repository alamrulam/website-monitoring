<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Proyek: {{ $proyek->nama_proyek }}
            </h2>
            <div class="flex space-x-2">
                {{-- TOMBOL BARU --}}
                <a href="{{ route('admin.proyek.cetakPdf', $proyek) }}" target="_blank">
                    <x-primary-button>{{ __('Cetak Laporan PDF') }}</x-primary-button>
                </a>
                <a href="{{ route('admin.proyek.index') }}">
                    <x-secondary-button>{{ __('Kembali') }}</x-secondary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Ringkasan Keuangan -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ringkasan Keuangan</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/50 rounded-lg">
                        <p class="text-sm text-blue-600 dark:text-blue-400">Total Anggaran</p>
                        <p class="text-2xl font-bold text-blue-800 dark:text-blue-200">Rp
                            {{ number_format($proyek->anggaran, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-red-50 dark:bg-red-900/50 rounded-lg">
                        <p class="text-sm text-red-600 dark:text-red-400">Total Pengeluaran</p>
                        <p class="text-2xl font-bold text-red-800 dark:text-red-200">Rp
                            {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 bg-green-50 dark:bg-green-900/50 rounded-lg">
                        <p class="text-sm text-green-600 dark:text-green-400">Sisa Anggaran</p>
                        <p class="text-2xl font-bold text-green-800 dark:text-green-200">Rp
                            {{ number_format($sisaAnggaran, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Jenis Kegiatan -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rincian Jenis Kegiatan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Jenis Kegiatan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Uraian</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Volume</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($proyek->kegiatans as $kegiatan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->nama_kegiatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->uraian ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->volume }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kegiatan->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Progres Fisik & Dokumentasi Foto (Versi Admin) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Progres Fisik & Dokumentasi</h3>
                <!-- Progress Bar -->
                <div>
                    <label for="progres_fisik_view"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Progres Fisik:
                        {{ $proyek->progres_fisik }}%</label>
                    <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700 mt-1">
                        <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $proyek->progres_fisik }}%"></div>
                    </div>
                </div>
                <!-- Galeri Foto -->
                <div class="mt-6">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Galeri Dokumentasi</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @forelse($proyek->dokumentasiFotos as $foto)
                            <div>
                                <a href="{{ asset('storage/' . $foto->foto_url) }}" target="_blank">
                                    {{-- PERUBAHAN DI SINI: Menggunakan aspect-square untuk rasio 1:1 --}}
                                    <img src="{{ asset('storage/' . $foto->foto_url) }}" alt="{{ $foto->keterangan }}"
                                        class="rounded-lg w-full h-full object-cover aspect-square">
                                </a>
                                <p class="text-xs text-center mt-1 text-gray-600 dark:text-gray-400 truncate">
                                    {{ $foto->keterangan }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">Pelaksana belum mengunggah foto dokumentasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Daftar Tenaga Kerja -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Daftar Tenaga Kerja</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Nama Pekerja</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Posisi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Telepon</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($proyek->tenagaKerja as $pekerja)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->nama_pekerja }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->posisi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->telepon ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">Pelaksana belum menambahkan data tenaga
                                        kerja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buku Kas Proyek -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Buku Kas Proyek (Riwayat
                    Transaksi)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Uraian</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Kategori</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Pemasukan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Pengeluaran</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($proyek->pembayaran as $bayar)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($bayar->tanggal_transaksi)->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $bayar->uraian }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $bayar->kategori }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600">
                                        @if ($bayar->jenis == 'Pemasukan')
                                            Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-600">
                                        @if ($bayar->jenis == 'Pengeluaran')
                                            Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($bayar->bukti_url)
                                            <a href="{{ asset('storage/' . $bayar->bukti_url) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900">Lihat Bukti</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Pelaksana belum mencatat transaksi
                                        apapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
