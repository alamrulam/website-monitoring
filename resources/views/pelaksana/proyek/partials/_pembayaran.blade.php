<!-- Manajemen Pembayaran -->
<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Buku Kas Proyek (Pembayaran)</h3>
    <div class="flex space-x-2">
        <a href="{{ route('pelaksana.proyek.pembayaran.create', ['proyek' => $proyek, 'jenis' => 'Pemasukan']) }}">
            <x-primary-button>+ Catat Pemasukan</x-primary-button>
        </a>
        <a href="{{ route('pelaksana.proyek.pembayaran.create', ['proyek' => $proyek, 'jenis' => 'Pengeluaran']) }}">
            <x-secondary-button>+ Catat Pengeluaran</x-secondary-button>
        </a>
    </div>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Uraian
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Pemasukan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                    Pengeluaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
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
                        @endif

                        <a href="{{ route('pelaksana.proyek.pembayaran.edit', [$proyek, $bayar]) }}"
                            class="text-indigo-600 hover:text-indigo-900 ml-2">Edit</a>

                        <form action="{{ route('pelaksana.proyek.pembayaran.destroy', [$proyek, $bayar]) }}"
                            method="POST" class="inline-block ml-2"
                            onsubmit="return confirm('Yakin hapus transaksi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada transaksi yang dicatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
