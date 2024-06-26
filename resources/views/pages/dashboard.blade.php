@extends('layouts.dashboard') <!-- Meng-extend layout dasar bernama "dashboard" -->

@section('content')
    <!-- Memulai section 'content' -->

    <head>
        <!-- Metadata dan stylesheet untuk halaman -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Menghubungkan stylesheet untuk halaman -->
        <link rel="stylesheet" href="css/char.css">
        <link rel="icon" href="images/logo.svg" type="image/icon type">
        <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Menghubungkan library JavaScript eksternal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <style>
            /* Styling untuk kontainer grafik */
            .chart-container {
                display: flex;
                justify-content: center;
            }

            .chart-box {
                width: 80%;
            }
        </style>
    </head>

    <body onload="startTime()"> <!-- Memanggil fungsi startTime saat halaman dimuat -->
        <div class="header"></div> <!-- Elemen header kosong -->
        <div class="dashboard"> <!-- Kontainer utama untuk dashboard -->
            <div class="mainrow"> <!-- Baris utama yang berisi beberapa box -->
                <div class="box1"> <!-- Box untuk informasi cuaca -->
                    <h2>Today</h2>
                    <div class="datetime"> <!-- Menampilkan tanggal dan waktu -->
                        <p style="margin-right: 30px;" id="date"></p>
                        <p id="time"></p>
                    </div>
                    <span class="tempsymbol"><i class="fas fa-clouds cloud"></i><span class="cloudy"> Cloudy</span></span>
                    <div class="temp"> <!-- Informasi suhu dan kelembaban -->
                        <div class="Temperature">
                            <strong id="temperature">--</strong><sup>°C</sup>
                            <p>Temperature</p>
                        </div>

                        <div class="Humidity">
                            <strong id="humidity">--</strong>
                            <p>Humidity</p>
                        </div>
                    </div>
                </div>
                <div class="box2"> <!-- Box untuk sensor gas -->
                    <h2>Gas Sensor</h2>
                    <div id="gasGauge" class="gauge-container"></div>
                </div>
                <div class="box3"> <!-- Box untuk sensor hujan -->
                    <h2>Rain Sensor</h2>
                    <div id="rainGauge" class="gauge-container"></div>
                </div>
            </div>

            <div class="box4"> <!-- Box untuk LED RGB -->
                <h2>LED RGB</h2>
                <p>User: {{ auth()->user()->name }}</p> <!-- Menampilkan nama pengguna yang sedang login -->
                <p id="ledNled">Loading...</p>
                <p id="ledStatus">Loading...</p>
            </div>

            <div class="box5"> <!-- Box untuk notifikasi -->
                <h2>Notifikasi</h2>
                <p id="notificationMessage">Loading...</p>
                <p id="notificationUser">Loading...</p>
                <p id="notificationSent">Loading...</p>
            </div>

            <script src="js/smart.js"></script> <!-- Menghubungkan skrip JavaScript untuk halaman -->
            <div class="chart-container"> <!-- Kontainer untuk grafik -->
                <canvas id="myChart" style="width:1000px;max-width:900px"></canvas>
            </div>
            <script>
                // Fungsi untuk mengambil notifikasi terbaru dari server
                async function fetchNotification() {
                    const response = await fetch('{{ route('notifications.latest') }}');
                    const result = await response.json();
                    return result;
                }

                // Memperbarui elemen notifikasi dengan data yang diambil
                fetchNotification().then(notification => {
                    document.getElementById('notificationMessage').innerText = `Message: ${notification.message}`;
                    document.getElementById('notificationUser').innerText = `User: ${notification.user_id}`;
                    document.getElementById('notificationSent').innerText =
                        `Sent: ${notification.sent ? 'Terkirim' : 'Belum Terkirim'}`;
                });

                // Fungsi untuk mengambil status LED terbaru dari server
                async function fetchLED() {
                    const response = await fetch('{{ route('leds.latest') }}');
                    const result = await response.json();
                    return result;
                }

                // Memperbarui elemen status LED dengan data yang diambil
                fetchLED().then(leds => {
                    document.getElementById('ledNled').innerText = `Tipe: ${leds.nama_led}`;
                    document.getElementById('ledStatus').innerText = `Status: ${leds.status ? 'Aktif' : 'Tidak Aktif'}`;
                });

                // Fungsi untuk mengambil data sensor dari server
                async function fetchData() {
                    const response = await fetch('{{ url('api/sensor') }}');
                    const result = await response.json();
                    return result.data.slice(0, 5);
                }

                let chart; // Variabel untuk menyimpan instance grafik

                // Fungsi untuk memperbarui grafik dengan data terbaru
                async function updateChart() {
                    const sensorData = await fetchData();
                    const labels = sensorData.map(sensor => new Date(sensor.created_at).toLocaleString());
                    const temperatureData = sensorData.map(sensor => parseFloat(sensor.temperature).toFixed(1));
                    const humidityData = sensorData.map(sensor => sensor.humidity);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    if (chart) {
                        chart.destroy();
                    }
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Temperature (°C)',
                                data: temperatureData,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            }, {
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
                                }
                            }
                        }
                    });
                }

                // Memperbarui grafik setiap 5 detik
                setInterval(updateChart, 5000);
                // Memperbarui grafik saat halaman pertama kali dimuat
                updateChart();

                let gasGauge, rainGauge; // Variabel untuk menyimpan instance gauge

                // Fungsi untuk memperbarui data pada gauge dengan data terbaru
                async function updateGauges() {
                    const response = await fetch('{{ url('api/sensor') }}');
                    const result = await response.json();
                    const sensorData = result.data;

                    if (sensorData.length > 0) {
                        const latestData = sensorData[0];
                        const gasLevel = latestData.gas_level;
                        const rainDetected = latestData.rain_detected ? 1 : 0;
                        document.getElementById('temperature').innerText = parseFloat(latestData.temperature).toFixed(1);
                        document.getElementById('humidity').innerText = latestData.humidity + '%';

                        if (gasGauge) {
                            gasGauge.refresh(gasLevel);
                        } else {
                            gasGauge = new JustGage({
                                id: "gasGauge",
                                value: gasLevel,
                                min: 0,
                                max: 1000,
                                title: "Gas Level",
                                label: "ppm",
                                levelColors: ["#00ff00", "#ff0000"]
                            });
                        }

                        if (rainGauge) {
                            rainGauge.refresh(rainDetected);
                        } else {
                            rainGauge = new JustGage({
                                id: "rainGauge",
                                value: rainDetected,
                                min: 0,
                                max: 1,
                                title: "Rain Detection",
                                label: rainDetected ? "Hujan" : "Tidak Hujan",
                                levelColors: ["#00ff00", "#0000ff"]
                            });
                        }
                    }
                }

                // Memperbarui gauge dan data box1 setiap 5 detik
                setInterval(updateGauges, 5000);
                // Memperbarui gauge dan data box1 saat halaman pertama kali dimuat
                updateGauges();
            </script>
    </body>

    </html>
@endsection <!-- Mengakhiri section 'content' -->
