<!-- Ringkasan Keuangan -->
<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ringkasan Keuangan</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Anggaran</p>
        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">Rp
            {{ number_format($proyek->anggaran, 0, ',', '.') }}</p>
    </div>
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
        <p class="text-2xl font-bold text-red-600 dark:text-red-400">Rp
            {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
    </div>
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-400">Sisa Anggaran</p>
        <p class="text-2xl font-bold text-green-600 dark:text-green-400">Rp
            {{ number_format($sisaAnggaran, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Detail Jenis Kegiatan -->
<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-8 mb-4">Rincian Jenis Kegiatan</h3>
<div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jenis
                    Kegiatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Uraian
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Panjang
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Satuan
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
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
