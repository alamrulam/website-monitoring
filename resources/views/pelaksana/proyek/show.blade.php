<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Proyek: {{ $proyek->nama_proyek }}
            </h2>
            {{-- TOMBOL BARU --}}
            <a href="{{ route('pelaksana.proyek.cetakPdf', $proyek) }}" target="_blank">
                <x-primary-button>{{ __('Cetak Laporan PDF') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

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

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                     <!-- Progres Fisik & Dokumentasi Foto -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Progres Fisik & Dokumentasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form Update Progres -->
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Update Progres Fisik</h4>
                        <form action="{{ route('pelaksana.proyek.updateProgres', $proyek) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="progres_fisik" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Progres Saat Ini: {{ $proyek->progres_fisik }}%</label>
                            <input type="range" id="progres_fisik" name="progres_fisik" min="0" max="100" value="{{ $proyek->progres_fisik }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" oninput="progressValue.innerText = this.value">
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                                <span>0%</span>
                                <span id="progressValue">{{ $proyek->progres_fisik }}</span>%
                                <span>100%</span>
                            </div>
                            <x-primary-button class="mt-2">Update Progres</x-primary-button>
                        </form>
                    </div>
                    <!-- Form Upload Foto -->
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Unggah Foto Dokumentasi</h4>
                        <form action="{{ route('pelaksana.proyek.uploadFoto', $proyek) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <x-input-label for="keterangan" value="Keterangan Foto" />
                                <x-text-input id="keterangan" name="keterangan" type="text" class="mt-1 block w-full" required placeholder="Contoh: Kondisi 0%, Pengecoran, dll." />
                            </div>
                            <div class="mt-2">
                                <x-input-label for="foto" value="Pilih File Gambar" />
                                <input id="foto" name="foto" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" required />
                            </div>
                            <x-primary-button class="mt-2">Unggah Foto</x-primary-button>
                        </form>
                    </div>
                </div>
                <!-- Galeri Foto -->
                <div class="mt-6">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Galeri Dokumentasi</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @forelse($proyek->dokumentasiFotos as $foto)
                            <div class="relative group">
                                {{-- PERUBAHAN DI SINI: Menggunakan aspect-square untuk rasio 1:1 --}}
                                <img src="{{ asset('storage/' . $foto->foto_url) }}" alt="{{ $foto->keterangan }}" class="rounded-lg w-full h-full object-cover aspect-square">
                                <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-xs p-1 w-full rounded-b-lg truncate">{{ $foto->keterangan }}</div>
                                <form action="{{ route('pelaksana.proyek.hapusFoto', [$proyek, $foto]) }}" method="POST" onsubmit="return confirm('Yakin hapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">Belum ada foto dokumentasi yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
            </div>

                    <!-- Manajemen Tenaga Kerja -->
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Tenaga Kerja</h3>
                            <a href="{{ route('pelaksana.proyek.tenaga-kerja.create', $proyek) }}">
                                <x-primary-button>+ Tambah Pekerja</x-primary-button>
                            </a>
                        </div>
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
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($proyek->tenagaKerja as $pekerja)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->nama_pekerja }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->posisi }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->telepon ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form
                                                    action="{{ route('pelaksana.proyek.tenaga-kerja.destroy', [$proyek, $pekerja]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin hapus pekerja ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">Belum ada tenaga kerja yang
                                                ditambahkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Manajemen Pembayaran -->
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Buku Kas Proyek
                                (Pembayaran)</h3>
                            <div class="flex space-x-2">
                                <a
                                    href="{{ route('pelaksana.proyek.pembayaran.create', ['proyek' => $proyek, 'jenis' => 'Pemasukan']) }}">
                                    <x-primary-button>+ Catat Pemasukan</x-primary-button>
                                </a>
                                <a
                                    href="{{ route('pelaksana.proyek.pembayaran.create', ['proyek' => $proyek, 'jenis' => 'Pengeluaran']) }}">
                                    <x-secondary-button>+ Catat Pengeluaran</x-secondary-button>
                                </a>
                            </div>
                        </div>
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
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($proyek->pembayaran as $bayar)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($bayar->tanggal_transaksi)->format('d M Y') }}
                                            </td>
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
                                                    <a href="{{ asset('storage/' . $bayar->bukti_url) }}"
                                                        target="_blank"
                                                        class="text-blue-600 hover:text-blue-900">Lihat Bukti</a>
                                                @endif
                                                <form
                                                    action="{{ route('pelaksana.proyek.pembayaran.destroy', [$proyek, $bayar]) }}"
                                                    method="POST" class="inline-block ml-2"
                                                    onsubmit="return confirm('Yakin hapus transaksi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">Belum ada transaksi yang
                                                dicatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
