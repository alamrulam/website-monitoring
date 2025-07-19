<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Proyek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.proyek.create') }}">
                            <x-primary-button>{{ __('Tambah Proyek') }}</x-primary-button>
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Proyek</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Pelaksana</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Anggaran</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($proyeks as $proyek)
                                    <tr>
                                        {{-- GANTI BARIS INI --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.proyek.show', $proyek) }}"
                                                class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                                {{ $proyek->nama_proyek }}
                                            </a>
                                        </td>
                                        {{-- DARI BARIS INI --}}

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $proyek->pelaksana->nama_perusahaan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp
                                            {{ number_format($proyek->anggaran, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- ... (kode status tetap sama) ... --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            {{-- ... (kode tombol edit & hapus tetap sama) ... --}}
                                        </td>
                                    </tr>
                                @empty
                                    {{-- ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $proyeks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
