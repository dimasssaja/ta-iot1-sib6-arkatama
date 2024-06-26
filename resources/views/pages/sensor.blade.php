@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <!-- Membuat sebuah 'div' dengan kelas 'container' dan 'mt-5' (margin-top 5). Ini adalah container utama untuk semua konten halaman ini -->

        <div class="chart-container">
            <!-- Membuat 'div' untuk menampung grafik-grafik yang akan ditampilkan -->

            <!-- Line Chart for Temperature -->
            <div class="chart-box">
                <h2>Temperature</h2>
                <canvas id="temperatureChart"></canvas>
            </div>

            <!-- Line Chart for Humidity -->
            <div class="chart-box">
                <h2>Humidity</h2>
                <canvas id="humidityChart"></canvas>
            </div>
        </div>

        <div class="box2-sensor">
            <h2>Gas Sensor</h2>
            <div id="gasGauge" class="gauge-container"></div>
        </div>

        <div class="box3-sensor">
            <h2>Rain Sensor</h2>
            <div id="rainGauge" class="gauge-container"></div>
        </div>
    </div>

    <!-- Menambahkan pustaka Chart.js dari CDN untuk membuat grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Menambahkan pustaka Raphael.js dari CDN, yang merupakan dependensi untuk justgage -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>

    <!-- Menambahkan pustaka JustGage dari CDN untuk membuat gauge -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menambahkan event listener yang akan menjalankan kode di dalamnya setelah seluruh konten halaman selesai dimuat

            async function fetchData() {
                // Fungsi asinkron untuk mengambil data sensor dari API
                const response = await fetch('{{ url('api/sensor') }}');
                // Mengambil data dari API
                const result = await response.json();
                // Mengkonversi response ke format JSON
                return result.data.slice(0, 5);
                // Mengembalikan 5 data terbaru
            }

            let temperatureChart, humidityChart;
            // Mendeklarasikan variabel untuk menyimpan objek grafik

            async function updateCharts() {
                // Fungsi asinkron untuk memperbarui grafik
                const sensorData = await fetchData();
                // Mengambil data sensor
                const labels = sensorData.map(sensor => new Date(sensor.created_at).toLocaleString());
                // Membuat label tanggal dari data sensor
                const temperatureData = sensorData.map(sensor => parseFloat(sensor.temperature).toFixed(1));
                // Mengolah data suhu, memastikan satu tempat desimal
                const humidityData = sensorData.map(sensor => sensor.humidity);
                // Mengolah data kelembapan

                const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
                // Mendapatkan context 2D untuk 'temperatureChart'
                if (temperatureChart) {
                    temperatureChart.destroy();
                    // Menghancurkan grafik lama jika ada
                }
                temperatureChart = new Chart(ctxTemperature, {
                    // Membuat grafik baru
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Temperature (°C)',
                            data: temperatureData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                                // Memulai skala y dari nol
                            }
                        }
                    }
                });

                const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
                // Mendapatkan context 2D untuk 'humidityChart'
                if (humidityChart) {
                    humidityChart.destroy();
                    // Menghancurkan grafik lama jika ada
                }
                humidityChart = new Chart(ctxHumidity, {
                    // Membuat grafik baru
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Humidity (%)',
                            data: humidityData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                                // Memulai skala y dari nol
                            }
                        }
                    }
                });
            }

            setInterval(updateCharts, 5000);
            // Memperbarui grafik setiap 5 detik
            updateCharts();
            // Memperbarui grafik saat halaman pertama kali dimuat

            async function fetchSensorData() {
                // Fungsi asinkron untuk mengambil data sensor
                const response = await fetch('{{ url('api/sensor') }}');
                // Mengambil data dari API
                const result = await response.json();
                // Mengkonversi response ke format JSON
                return result.data;
                // Mengembalikan seluruh data sensor
            }

            fetchSensorData().then(sensorData => {
                // Mengambil data sensor dan kemudian menjalankan fungsi berikutnya
                if (sensorData.length > 0) {
                    // Jika data sensor tersedia
                    const latestData = sensorData[0];
                    // Mengambil data terbaru
                    const gasLevel = latestData.gas_level;
                    // Mendapatkan tingkat gas
                    const rainDetected = latestData.rain_detected ? 1 : 0;
                    // Mendapatkan status deteksi hujan (1 jika hujan, 0 jika tidak)

                    // Membuat gauge untuk sensor gas
                    const gasGauge = new JustGage({
                        id: "gasGauge",
                        value: gasLevel,
                        min: 0,
                        max: 1000,
                        title: "Gas Level",
                        label: "ppm",
                        levelColors: ["#00ff00", "#ff0000"]
                    });

                    // Membuat gauge untuk sensor hujan
                    const rainGauge = new JustGage({
                        id: "rainGauge",
                        value: rainDetected,
                        min: 0,
                        max: 1,
                        title: "Rain Detection",
                        label: rainDetected ? "Hujan" : "Tidak Hujan",
                        levelColors: ["#00ff00", "#0000ff"]
                    });
                }
            });
        });
    </script>
@endsection
