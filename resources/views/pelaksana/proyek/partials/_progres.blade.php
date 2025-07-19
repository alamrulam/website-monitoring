<!-- Progres Fisik & Dokumentasi Foto -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Form Update Progres -->
    <div>
        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Update Progres Fisik</h4>
        <form action="{{ route('pelaksana.proyek.updateProgres', $proyek) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="progres_fisik" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Progres Saat
                Ini: {{ $proyek->progres_fisik }}%</label>
            <input type="range" id="progres_fisik" name="progres_fisik" min="0" max="100"
                value="{{ $proyek->progres_fisik }}"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                oninput="progressValue.innerText = this.value">
            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                <span>0%</span>
                <span id="progressValue">{{ $proyek->progres_fisik }}</span>%
                <span>100%</span>
            </div>
            <x-primary-button class="mt-2">Update Progres</x-primary-button>
        </form>
    </div>
    <!-- Form Upload Foto -->
    <div>
        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Unggah Foto Dokumentasi</h4>
        <form action="{{ route('pelaksana.proyek.uploadFoto', $proyek) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <x-input-label for="keterangan" value="Keterangan Foto" />
                <x-text-input id="keterangan" name="keterangan" type="text" class="mt-1 block w-full" required
                    placeholder="Contoh: Kondisi 0%, Pengecoran, dll." />
            </div>
            <div class="mt-2">
                <x-input-label for="foto" value="Pilih File Gambar" />
                <input id="foto" name="foto" type="file"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"
                    required />
            </div>
            <x-primary-button class="mt-2">Unggah Foto</x-primary-button>
        </form>
    </div>
</div>
<!-- Galeri Foto -->
<div class="mt-6">
    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Galeri Dokumentasi</h4>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($proyek->dokumentasiFotos as $foto)
            <div class="relative group">
                <img src="{{ asset('storage/' . $foto->foto_url) }}" alt="{{ $foto->keterangan }}"
                    class="rounded-lg w-full h-full object-cover aspect-square">
                <div
                    class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-xs p-1 w-full rounded-b-lg truncate">
                    {{ $foto->keterangan }}</div>
                <form action="{{ route('pelaksana.proyek.hapusFoto', [$proyek, $foto]) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus foto ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 col-span-full">Belum ada foto dokumentasi yang diunggah.</p>
        @endforelse
    </div>
</div>
