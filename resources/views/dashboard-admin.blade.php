<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Kartu Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Proyek -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Proyek</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalProyek }}</p>
                </div>
                <!-- Total Pelaksana -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Pelaksana</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalPelaksana }}</p>
                </div>
                <!-- Total Anggaran -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Anggaran</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">Rp
                        {{ number_format($totalAnggaran, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Grafik Proyek -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Statistik Status Proyek</h3>

                    {{-- ====================================================== --}}
                    {{-- PERUBAHAN DI SINI --}}
                    {{-- Kita batasi lebar dan tinggi maksimum dari kontainer grafik --}}
                    {{-- ====================================================== --}}
                    <div class="relative mx-auto" style="max-height:400px; max-width:400px;">
                        <canvas id="statusProyekChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            // Hanya tampilkan grafik jika ada data
            if (chartData.length > 0) {
                const ctx = document.getElementById('statusProyekChart');
                const statusProyekChart = new Chart(ctx, {
                    type: 'pie', // Tipe grafik: pie (lingkaran)
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Jumlah Proyek',
                            data: chartData,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.7)', // Biru (Perencanaan)
                                'rgba(255, 206, 86, 0.7)', // Kuning (Berjalan)
                                'rgba(75, 192, 192, 0.7)', // Hijau (Selesai)
                                'rgba(255, 99, 132, 0.7)', // Merah (Dibatalkan)
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Status Proyek'
                            }
                        }
                    }
                });
            } else {
                // Jika tidak ada data, tampilkan pesan
                const canvas = document.getElementById('statusProyekChart');
                const ctx = canvas.getContext('2d');
                ctx.textAlign = 'center';
                ctx.fillText('Belum ada data proyek untuk ditampilkan.', canvas.width / 2, canvas.height / 2);
            }
        });
    </script>
</x-app-layout>
