<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proyek Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Proyek yang Ditugaskan</h3>
                    <div class="space-y-4">
                        @forelse ($proyeks as $proyek)
                            <a href="{{ route('pelaksana.proyek.show', $proyek) }}"
                                class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">{{ $proyek->nama_proyek }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $proyek->lokasi }}</p>
                                    </div>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if ($proyek->status == 'Selesai') bg-green-100 text-green-800 @endif
                                        @if ($proyek->status == 'Berjalan') bg-yellow-100 text-yellow-800 @endif
                                        @if ($proyek->status == 'Perencanaan') bg-blue-100 text-blue-800 @endif
                                        @if ($proyek->status == 'Dibatalkan') bg-red-100 text-red-800 @endif
                                    ">
                                        {{ $proyek->status }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p>Belum ada proyek yang ditugaskan kepada Anda.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        {{ $proyeks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
