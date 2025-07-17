<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pelaksana Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.pelaksana.store') }}">
                        @csrf
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Dasar</h3>

                        <!-- Nama Perusahaan -->
                        <div>
                            <x-input-label for="nama_perusahaan" :value="__('Nama Perusahaan')" />
                            <x-text-input id="nama_perusahaan" class="block mt-1 w-full" type="text"
                                name="nama_perusahaan" :value="old('nama_perusahaan')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_perusahaan')" class="mt-2" />
                        </div>

                        <!-- Nama Kontak -->
                        <div class="mt-4">
                            <x-input-label for="nama_kontak" :value="__('Nama Kontak Person')" />
                            <x-text-input id="nama_kontak" class="block mt-1 w-full" type="text" name="nama_kontak"
                                :value="old('nama_kontak')" required />
                            <x-input-error :messages="$errors->get('nama_kontak')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email (untuk login)')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Telepon -->
                        <div class="mt-4">
                            <x-input-label for="telepon" :value="__('Nomor Telepon')" />
                            <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon"
                                :value="old('telepon')" required />
                            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <textarea id="alamat" name="alamat"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>{{ old('alamat') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Tambahan (Legal
                            & Keuangan)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nomor Kontrak -->
                            <div>
                                <x-input-label for="nomor_kontrak" :value="__('Nomor Kontrak/Penunjukan')" />
                                <x-text-input id="nomor_kontrak" class="block mt-1 w-full" type="text"
                                    name="nomor_kontrak" :value="old('nomor_kontrak')" />
                                <x-input-error :messages="$errors->get('nomor_kontrak')" class="mt-2" />
                            </div>

                            <!-- Tanggal Kontrak -->
                            <div>
                                <x-input-label for="tanggal_kontrak" :value="__('Tanggal Kontrak')" />
                                <x-text-input id="tanggal_kontrak" class="block mt-1 w-full" type="date"
                                    name="tanggal_kontrak" :value="old('tanggal_kontrak')" />
                                <x-input-error :messages="$errors->get('tanggal_kontrak')" class="mt-2" />
                            </div>

                            <!-- Nama Bank -->
                            <div>
                                <x-input-label for="nama_bank" :value="__('Nama Bank')" />
                                <x-text-input id="nama_bank" class="block mt-1 w-full" type="text" name="nama_bank"
                                    :value="old('nama_bank')" />
                                <x-input-error :messages="$errors->get('nama_bank')" class="mt-2" />
                            </div>

                            <!-- Nomor Rekening -->
                            <div>
                                <x-input-label for="nomor_rekening" :value="__('Nomor Rekening')" />
                                <x-text-input id="nomor_rekening" class="block mt-1 w-full" type="text"
                                    name="nomor_rekening" :value="old('nomor_rekening')" />
                                <x-input-error :messages="$errors->get('nomor_rekening')" class="mt-2" />
                            </div>

                            <!-- Atas Nama Rekening -->
                            <div class="md:col-span-2">
                                <x-input-label for="atas_nama_rekening" :value="__('Atas Nama Rekening')" />
                                <x-text-input id="atas_nama_rekening" class="block mt-1 w-full" type="text"
                                    name="atas_nama_rekening" :value="old('atas_nama_rekening')" />
                                <x-input-error :messages="$errors->get('atas_nama_rekening')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.pelaksana.index') }}">
                                <x-secondary-button class="ml-3">
                                    {{ __('Batal') }}
                                    </x--secondary-button>
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
