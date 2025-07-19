<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $proyek->nama_proyek }}
                </h2>
                <p class="text-sm text-gray-500">{{ $proyek->lokasi }}</p>
            </div>
            <a href="{{ route('pelaksana.proyek.cetakPdf', $proyek) }}" target="_blank">
                <x-primary-button>{{ __('Cetak Laporan PDF') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow-lg sm:rounded-lg">
                {{-- Memanggil Sub-Menu Navigasi --}}
                @include('layouts.proyek-navigation')

                <div class="mt-6">
                    {{-- Menampilkan konten sesuai tab yang aktif --}}
                    @if ($tab == 'detail')
                        @include('pelaksana.proyek.partials._detail')
                    @elseif($tab == 'progres')
                        @include('pelaksana.proyek.partials._progres')
                    @elseif($tab == 'tenaga-kerja')
                        @include('pelaksana.proyek.partials._tenaga-kerja')
                    @elseif($tab == 'pembayaran')
                        @include('pelaksana.proyek.partials._pembayaran')
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
