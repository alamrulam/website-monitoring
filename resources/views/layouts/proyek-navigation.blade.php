<div class="border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        <a href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'detail']) }}"
            class="{{ $tab == 'detail' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Detail & Keuangan
        </a>
        <a href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'progres']) }}"
            class="{{ $tab == 'progres' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Progres & Foto
        </a>
        <a href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'tenaga-kerja']) }}"
            class="{{ $tab == 'tenaga-kerja' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Tenaga Kerja
        </a>
        <a href="{{ route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'pembayaran']) }}"
            class="{{ $tab == 'pembayaran' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Buku Kas
        </a>
    </nav>
</div>
