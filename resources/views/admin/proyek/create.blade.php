<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Proyek Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <p class="font-bold">Terjadi Kesalahan:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.proyek.store') }}">
                        @csrf

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Proyek</h3>

                        <!-- Form Informasi Proyek (Sama seperti sebelumnya) -->
                        <div>
                            <x-input-label for="nama_proyek" :value="__('Nama Proyek')" />
                            <x-text-input id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek"
                                :value="old('nama_proyek')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="pelaksana_id" :value="__('Tugaskan ke Pelaksana')" />
                            <select id="pelaksana_id" name="pelaksana_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>
                                <option value="">-- Pilih Pelaksana --</option>
                                @foreach ($pelaksanas as $pelaksana)
                                    <option value="{{ $pelaksana->id }}"
                                        {{ old('pelaksana_id') == $pelaksana->id ? 'selected' : '' }}>
                                        {{ $pelaksana->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="lokasi" :value="__('Lokasi Proyek')" />
                            <textarea id="lokasi" name="lokasi"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>{{ old('lokasi') }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="anggaran" :value="__('Anggaran (Rp)')" />
                            <x-text-input id="anggaran" class="block mt-1 w-full" type="number" name="anggaran"
                                :value="old('anggaran')" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date"
                                    name="tanggal_mulai" :value="old('tanggal_mulai')" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="date"
                                    name="tanggal_selesai" :value="old('tanggal_selesai')" />
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Jenis Kegiatan</h3>

                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <!-- Nama Kegiatan (DROPDOWN) -->
                                <div class="md:col-span-4">
                                    <x-input-label for="nama_kegiatan" value="Jenis Kegiatan" />
                                    <select id="nama_kegiatan" name="nama_kegiatan"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                        required>
                                        <option value="">-- Pilih Kegiatan --</option>
                                        @foreach ($masterKegiatans as $master)
                                            <option value="{{ $master->nama_kegiatan }}"
                                                {{ old('nama_kegiatan') == $master->nama_kegiatan ? 'selected' : '' }}>
                                                {{ $master->nama_kegiatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Uraian -->
                                <div class="md:col-span-4">
                                    <x-input-label for="uraian" value="Uraian (Opsional)" />
                                    <x-text-input id="uraian" class="block mt-1 w-full" type="text" name="uraian"
                                        :value="old('uraian')" />
                                </div>
                                <!-- Volume -->
                                <div class="md:col-span-2">
                                    <x-input-label for="volume" value="Volume" />
                                    <x-text-input id="volume" class="block mt-1 w-full" type="number" name="volume"
                                        :value="old('volume')" required step="0.01" />
                                </div>
                                <!-- Satuan (DROPDOWN) -->
                                <div class="md:col-span-2">
                                    <x-input-label for="satuan" value="Satuan" />
                                    <select id="satuan" name="satuan"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                        required>
                                        @foreach ($satuans as $satuan)
                                            <option value="{{ $satuan }}"
                                                {{ old('satuan', 'm2') == $satuan ? 'selected' : '' }}>
                                                {{ $satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.proyek.index') }}">
                                <x-secondary-button type="button" class="ml-3">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Simpan Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
