<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Proyek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.proyek.update', $proyek) }}" x-data="proyekForm(@json($proyek->kegiatans))">
                        @csrf
                        @method('PUT')

                        {{-- Bagian Data Proyek Utama --}}
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Proyek</h3>

                        <!-- Nama Proyek -->
                        <div>
                            <x-input-label for="nama_proyek" :value="__('Nama Proyek')" />
                            <x-text-input id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek"
                                :value="old('nama_proyek', $proyek->nama_proyek)" required autofocus />
                        </div>

                        <!-- Tugaskan ke Pelaksana -->
                        <div class="mt-4">
                            <x-input-label for="pelaksana_id" :value="__('Tugaskan ke Pelaksana')" />
                            <select id="pelaksana_id" name="pelaksana_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                @foreach ($pelaksanas as $pelaksana)
                                    <option value="{{ $pelaksana->id }}"
                                        {{ old('pelaksana_id', $proyek->pelaksana_id) == $pelaksana->id ? 'selected' : '' }}>
                                        {{ $pelaksana->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-4">
                            <x-input-label for="lokasi" :value="__('Lokasi Proyek')" />
                            <textarea id="lokasi" name="lokasi"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>{{ old('lokasi', $proyek->lokasi) }}</textarea>
                        </div>

                        <!-- Anggaran -->
                        <div class="mt-4">
                            <x-input-label for="anggaran" :value="__('Anggaran (Rp)')" />
                            <x-text-input id="anggaran" class="block mt-1 w-full" type="number" name="anggaran"
                                :value="old('anggaran', $proyek->anggaran)" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- Tanggal Mulai -->
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date"
                                    name="tanggal_mulai" :value="old('tanggal_mulai', $proyek->tanggal_mulai)" />
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="date"
                                    name="tanggal_selesai" :value="old('tanggal_selesai', $proyek->tanggal_selesai)" />
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status Proyek')" />
                            <select id="status" name="status"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="Perencanaan"
                                    {{ old('status', $proyek->status) == 'Perencanaan' ? 'selected' : '' }}>Perencanaan
                                </option>
                                <option value="Berjalan"
                                    {{ old('status', $proyek->status) == 'Berjalan' ? 'selected' : '' }}>Berjalan
                                </option>
                                <option value="Selesai"
                                    {{ old('status', $proyek->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan"
                                    {{ old('status', $proyek->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                </option>
                            </select>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        {{-- Bagian Detail Kegiatan Dinamis --}}
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Detail Jenis Kegiatan</h3>
                            <x-secondary-button type="button" @click="addKegiatan()">+ Tambah
                                Kegiatan</x-secondary-button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(kegiatan, index) in kegiatans" :key="index">
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                                    <button type="button" @click="removeKegiatan(index)"
                                        class="absolute top-2 right-2 text-red-500 hover:text-red-700">&times;</button>
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                                        <!-- Nama Kegiatan (DROPDOWN) -->
                                        <div class="md:col-span-4">
                                            <x-input-label ::for="'kegiatan_' + index + '_nama'" value="Jenis Kegiatan" />
                                            <select ::id="'kegiatan_' + index + '_nama'"
                                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                x-model="kegiatan.nama_kegiatan"
                                                ::name="`kegiatan[${index}][nama_kegiatan]`" required>
                                                <option value="">-- Pilih Kegiatan --</option>
                                                @foreach ($masterKegiatans as $master)
                                                    <option value="{{ $master->nama_kegiatan }}">
                                                        {{ $master->nama_kegiatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Uraian -->
                                        <div class="md:col-span-4">
                                            <x-input-label ::for="'kegiatan_' + index + '_uraian'" value="Uraian (Opsional)" />
                                            <x-text-input ::id="'kegiatan_' + index + '_uraian'" class="block mt-1 w-full" type="text"
                                                x-model="kegiatan.uraian" ::name="`kegiatan[${index}][uraian]`" />
                                        </div>

                                        <!-- Volume -->
                                        <div class="md:col-span-2">
                                            <x-input-label ::for="'kegiatan_' + index + '_volume'" value="Volume" />
                                            <x-text-input ::id="'kegiatan_' + index + '_volume'" class="block mt-1 w-full" type="number"
                                                x-model="kegiatan.volume" ::name="`kegiatan[${index}][volume]`" required step="0.01" />
                                        </div>

                                        <!-- Satuan (DROPDOWN) -->
                                        <div class="md:col-span-2">
                                            <x-input-label ::for="'kegiatan_' + index + '_satuan'" value="Satuan" />
                                            <select ::id="'kegiatan_' + index + '_satuan'"
                                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                x-model="kegiatan.satuan" ::name="`kegiatan[${index}][satuan]`"
                                                required>
                                                @foreach ($satuans as $satuan)
                                                    <option value="{{ $satuan }}">{{ $satuan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.proyek.index') }}">
                                <x-secondary-button type="button" class="ml-3">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Update Proyek') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function proyekForm(kegiatansData) {
            return {
                kegiatans: kegiatansData || [],
                addKegiatan() {
                    this.kegiatans.push({
                        nama_kegiatan: '',
                        uraian: '',
                        volume: 1,
                        satuan: 'm2'
                    });
                },
                removeKegiatan(index) {
                    this.kegiatans.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>
