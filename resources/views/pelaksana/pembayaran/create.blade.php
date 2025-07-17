<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catat Transaksi {{ $jenis }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('pelaksana.proyek.pembayaran.store', $proyek) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ $jenis }}">

                        <!-- Tanggal Transaksi -->
                        <div>
                            <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                            <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date"
                                name="tanggal_transaksi" :value="old('tanggal_transaksi', date('Y-m-d'))" required />
                        </div>

                        <!-- Uraian -->
                        <div class="mt-4">
                            <x-input-label for="uraian" :value="__('Uraian Transaksi')" />
                            <textarea id="uraian" name="uraian"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>{{ old('uraian') }}</textarea>
                        </div>

                        <!-- Kategori -->
                        <div class="mt-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <select id="kategori" name="kategori"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>
                                @if ($jenis == 'Pemasukan')
                                    <option value="Dana Masuk">Dana Masuk</option>
                                @else
                                    <option value="Upah Tenaga Kerja">Upah Tenaga Kerja</option>
                                    <option value="Belanja Material">Belanja Material</option>
                                    <option value="Sewa Alat">Sewa Alat</option>
                                    <option value="Biaya Operasional">Biaya Operasional</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                @endif
                            </select>
                        </div>

                        <!-- Jumlah -->
                        <div class="mt-4">
                            <x-input-label for="jumlah" :value="__('Jumlah (Rp)')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah"
                                :value="old('jumlah')" required step="0.01" />
                        </div>

                        <!-- Bukti Pembayaran -->
                        <div class="mt-4">
                            <x-input-label for="bukti" :value="__('Upload Bukti (Opsional)')" />
                            <input id="bukti" name="bukti" type="file"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pelaksana.proyek.show', $proyek) }}"><x-secondary-button
                                    type="button">{{ __('Batal') }}</x-secondary-button></a>
                            <x-primary-button class="ml-3">{{ __('Simpan Transaksi') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
