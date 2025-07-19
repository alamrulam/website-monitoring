<!-- Manajemen Tenaga Kerja -->
<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Tenaga Kerja</h3>
    <a href="{{ route('pelaksana.proyek.tenaga-kerja.create', $proyek) }}"><x-primary-button>+ Tambah
            Pekerja</x-primary-button></a>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama
                    Pekerja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Posisi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Telepon
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($proyek->tenagaKerja as $pekerja)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->nama_pekerja }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->posisi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pekerja->telepon ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        {{-- TOMBOL EDIT BARU --}}
                        <a href="{{ route('pelaksana.proyek.tenaga-kerja.edit', [$proyek, $pekerja]) }}"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('pelaksana.proyek.tenaga-kerja.destroy', [$proyek, $pekerja]) }}"
                            method="POST" class="inline-block ml-4"
                            onsubmit="return confirm('Yakin hapus pekerja ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada tenaga kerja yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
