<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Tenaga Kerja untuk Proyek: {{ $proyek->nama_proyek }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('pelaksana.proyek.tenaga-kerja.store', $proyek) }}">
                        @csrf
                        <!-- Nama Pekerja -->
                        <div>
                            <x-input-label for="nama_pekerja" :value="__('Nama Pekerja')" />
                            <x-text-input id="nama_pekerja" class="block mt-1 w-full" type="text" name="nama_pekerja"
                                :value="old('nama_pekerja')" required autofocus />
                        </div>
                        <!-- Posisi -->
                        <div class="mt-4">
                            <x-input-label for="posisi" :value="__('Posisi/Jabatan')" />
                            <x-text-input id="posisi" class="block mt-1 w-full" type="text" name="posisi"
                                :value="old('posisi')" required placeholder="Contoh: Tukang, Pekerja, Mandor" />
                        </div>
                        <!-- Telepon -->
                        <div class="mt-4">
                            <x-input-label for="telepon" :value="__('Nomor Telepon (Opsional)')" />
                            <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon"
                                :value="old('telepon')" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pelaksana.proyek.show', $proyek) }}"><x-secondary-button
                                    type="button">{{ __('Batal') }}</x-secondary-button></a>
                            <x-primary-button class="ml-3">{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
