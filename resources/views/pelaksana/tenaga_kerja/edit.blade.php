<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Data Tenaga Kerja: {{ $tenagaKerja->nama_pekerja }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST"
                        action="{{ route('pelaksana.proyek.tenaga-kerja.update', [$proyek, $tenagaKerja]) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Pekerja -->
                            <div>
                                <x-input-label for="nama_pekerja" :value="__('Nama Lengkap Pekerja')" />
                                <x-text-input id="nama_pekerja" class="block mt-1 w-full" type="text"
                                    name="nama_pekerja" :value="old('nama_pekerja', $tenagaKerja->nama_pekerja)" required autofocus />
                            </div>
                            <!-- Tempat Lahir -->
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text"
                                    name="tempat_lahir" :value="old('tempat_lahir', $tenagaKerja->tempat_lahir)" required />
                            </div>
                            <!-- Pendidikan -->
                            <div>
                                <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                                <x-text-input id="pendidikan" class="block mt-1 w-full" type="text" name="pendidikan"
                                    :value="old('pendidikan', $tenagaKerja->pendidikan)" required />
                            </div>
                            <!-- Jenis Kelamin -->
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    required>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $tenagaKerja->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $tenagaKerja->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <!-- Posisi (Dropdown) -->
                            <div>
                                <x-input-label for="posisi" :value="__('Posisi/Jabatan')" />
                                <select id="posisi" name="posisi"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    required>
                                    @foreach ($posisiOptions as $posisi)
                                        <option value="{{ $posisi }}"
                                            {{ old('posisi', $tenagaKerja->posisi) == $posisi ? 'selected' : '' }}>
                                            {{ $posisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Telepon -->
                            <div>
                                <x-input-label for="telepon" :value="__('Nomor Telepon (Opsional)')" />
                                <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon"
                                    :value="old('telepon', $tenagaKerja->telepon)" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <a
                                href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'tenaga-kerja']) }}"><x-secondary-button
                                    type="button">{{ __('Batal') }}</x-secondary-button></a>
                            <x-primary-button class="ml-3">{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
