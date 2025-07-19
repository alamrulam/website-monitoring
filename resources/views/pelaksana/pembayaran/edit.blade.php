<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Transaksi
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST"
                        action="{{ route('pelaksana.proyek.pembayaran.update', [$proyek, $pembayaran]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Tanggal Transaksi -->
                        <div>
                            <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                            <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date"
                                name="tanggal_transaksi" :value="old('tanggal_transaksi', $pembayaran->tanggal_transaksi)" required />
                        </div>
                        <!-- Uraian -->
                        <div class="mt-4">
                            <x-input-label for="uraian" :value="__('Uraian Transaksi')" />
                            <textarea id="uraian" name="uraian"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>{{ old('uraian', $pembayaran->uraian) }}</textarea>
                        </div>
                        <!-- Kategori -->
                        <div class="mt-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <select id="kategori" name="kategori"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                required>
                                @if ($pembayaran->jenis == 'Pemasukan')
                                    <option value="Dana Masuk"
                                        {{ old('kategori', $pembayaran->kategori) == 'Dana Masuk' ? 'selected' : '' }}>
                                        Dana Masuk</option>
                                @else
                                    <option value="Upah Tenaga Kerja"
                                        {{ old('kategori', $pembayaran->kategori) == 'Upah Tenaga Kerja' ? 'selected' : '' }}>
                                        Upah Tenaga Kerja</option>
                                    <option value="Belanja Material"
                                        {{ old('kategori', $pembayaran->kategori) == 'Belanja Material' ? 'selected' : '' }}>
                                        Belanja Material</option>
                                    <option value="Sewa Alat"
                                        {{ old('kategori', $pembayaran->kategori) == 'Sewa Alat' ? 'selected' : '' }}>
                                        Sewa Alat</option>
                                    <option value="Biaya Operasional"
                                        {{ old('kategori', $pembayaran->kategori) == 'Biaya Operasional' ? 'selected' : '' }}>
                                        Biaya Operasional</option>
                                    <option value="Lain-lain"
                                        {{ old('kategori', $pembayaran->kategori) == 'Lain-lain' ? 'selected' : '' }}>
                                        Lain-lain</option>
                                @endif
                            </select>
                        </div>
                        <!-- Jumlah -->
                        <div class="mt-4">
                            <x-input-label for="jumlah" :value="__('Jumlah (Rp)')" />
                            <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah"
                                :value="old('jumlah', $pembayaran->jumlah)" required step="0.01" />
                        </div>
                        <!-- Bukti Pembayaran -->
                        <div class="mt-4">
                            <x-input-label for="bukti" :value="__('Upload Bukti Baru (Opsional)')" />
                            <input id="bukti" name="bukti" type="file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" />
                            @if ($pembayaran->bukti_url)
                                <p class="text-sm mt-2">Bukti saat ini: <a
                                        href="{{ asset('storage/' . $pembayaran->bukti_url) }}" target="_blank"
                                        class="text-blue-500">Lihat Bukti</a></p>
                            @endif
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a
                                href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'pembayaran']) }}"><x-secondary-button
                                    type="button">{{ __('Batal') }}</x-secondary-button></a>
                            <x-primary-button class="ml-3">{{ __('Update Transaksi') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
