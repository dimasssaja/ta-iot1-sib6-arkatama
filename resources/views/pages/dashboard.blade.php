@extends('layouts.dashboard')

@section('content')

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/char.css">
        <link rel="icon" href="images/logo.svg" type="image/icon type">
        <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <style>
            .chart-container {
                display: flex;
                justify-content: center;
            }

            .chart-box {
                width: 80%;
            }
        </style>
    </head>

    <body onload="startTime()">
        <div class="header">
        </div>
        <div class="dashboard">
            <div class="mainrow">
                <div class="box1">
                    <h2>Today</h2>
                    <div class="datetime">
                        <p style="margin-right: 30px;" id="date"></p>
                        <p id="time"></p>
                    </div>
                    <span class="tempsymbol"><i class="fas fa-clouds cloud"></i><span class="cloudy"> Cloudy</span></span>
                    <div class="temp">
                        <div class="Temperature">
                            <strong>33</strong><sup>°C</sup>
                            <p>Temperature</p>
                        </div>

                        <div class="Humidity">
                            <strong>64%</strong>
                            <p>Humidity</p>
                        </div>
                    </div>
                </div>
                <div class="box2">
                    <h2>Gas Sensor</h2>
                    <div id="gasGauge" class="gauge-container">
                        <div class="">
                        </div>
                    </div>
                    {{-- <div class="indicator">
                        <h4>bahaya</h4>
                    </div> --}}
                </div>
                <div class="box3">
                    <h2>Rain Sensor</h2>
                    <div id="rainGauge" class="gauge-container">
                        <div class="">
                        </div>
                    </div>
                    {{-- <div class="indicator">
                        <i class="fa-solid fa-cloud-rain">tidak terdeteksi</i>
                    </div> --}}
                </div>
            </div>

            <div class="box4">
                <h2>LED RGB</h2>
                <p>Tipe Led: Led RGB</p>
                <p>User: {{ auth()->user()->name }}</p>
                <p>Status: Aktif </p>
            </div>

            <div class="box5">
                <h2>Notifikasi</h2>
                <p>Message: Led Merah</p>
                <p>User: {{ auth()->user()->name }}</p>
                <p>Sent: Terkirim </p>
            </div>

            {{-- lihat semua data berarti routesnya route dari 1 layout yang berisi banyak datalog --}}
            <a href="{{ route('leds.led') }}" class="btn1 btn-primary">Lihat Semua Data</a>

            <script src="js/smart.js"></script>
            <div class="chart-container">
                <canvas id="myChart" style="width:1000px;max-width:900px"></canvas>
            </div>
            <script>
                async function fetchData() {
                    const response = await fetch('{{ url('api/sensor') }}');
                    const result = await response.json();
                    return result.data;
                }

                fetchData().then(sensorData => {
                    const labels = sensorData.map(sensor => new Date(sensor.created_at).toLocaleString());
                    const temperatureData = sensorData.map(sensor => sensor.temperature);
                    const humidityData = sensorData.map(sensor => sensor.humidity);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    new Chart(ctx, {
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
                });
                async function fetchSensorData() {
                    const response = await fetch('{{ url('api/sensor') }}');
                    const result = await response.json();
                    return result.data;
                }

                fetchSensorData().then(sensorData => {
                    if (sensorData.length > 0) {
                        const latestData = sensorData[0]; // Mengambil data terbaru
                        const gasLevel = latestData.gas_level;
                        const rainDetected = latestData.rain_detected ? 1 :
                            0; // Jika hujan terdeteksi, nilai 100, jika tidak nilai 0

                        // Membuat gauge untuk Gas Sensor
                        const gasGauge = new JustGage({
                            id: "gasGauge",
                            value: gasLevel,
                            min: 0,
                            max: 1000,
                            title: "Gas Level",
                            label: "ppm",
                            levelColors: ["#00ff00", "#ff0000"]
                        });

                        // Membuat gauge untuk Rain Sensor
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
            </script>
    </body>

    </html>
@endsection
