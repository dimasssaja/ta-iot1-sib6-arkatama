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
    <div class="header"></div>
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
                        <strong id="temperature">--</strong><sup>°C</sup>
                        <p>Temperature</p>
                    </div>

                    <div class="Humidity">
                        <strong id="humidity"></strong>
                        <p>Humidity</p>
                    </div>
                </div>
            </div>
            <div class="box2">
                <h2>Gas Sensor</h2>
                <div id="gasGauge" class="gauge-container"></div>
            </div>
            <div class="box3">
                <h2>Rain Sensor</h2>
                <div id="rainGauge" class="gauge-container"></div>
            </div>
        </div>

        <div class="box4">
            <h2>LED RGB</h2>
            <p>User: {{ auth()->user()->name }}</p>
            <p id="ledNled">Loading...</p>
            <p id="ledStatus">Loading...</p>
            {{-- @if($latestLed)
                <p>Status: {{ $latestLed->status ? 'Aktif' : 'Tidak Aktif' }}</p>
                <p>Tipe Led: {{ $latestLed->nama_led }}</p>
            @else
                <p>Status: Tidak Ada Data</p>
            @endif --}}
        </div>

        <div class="box5">
            <h2>Notifikasi</h2>
            <p id="notificationMessage">Loading...</p>
            <p id="notificationUser">Loading...</p>
            <p id="notificationSent">Loading...</p>
        </div>

        <a href="{{ route('leds.led') }}" class="btn1 btn-primary">Lihat Semua Data</a>

        <script src="js/smart.js"></script>
        <div class="chart-container">
            <canvas id="myChart" style="width:1000px;max-width:900px"></canvas>
        </div>
        <script>
            async function fetchNotification() {
                const response = await fetch('{{ route('notifications.latest') }}');
                const result = await response.json();
                return result;
            }

            fetchNotification().then(notification => {
                document.getElementById('notificationMessage').innerText = `Message: ${notification.message}`;
                document.getElementById('notificationUser').innerText = `User: ${notification.user_id}`;
                document.getElementById('notificationSent').innerText = `Sent: ${notification.sent ? 'Terkirim' : 'Belum Terkirim'}`;
            });

            async function fetchLED() {
                const response = await fetch('{{ route('leds.latest') }}');
                const result = await response.json();
                return result;
            }

            fetchLED().then(leds => {
                document.getElementById('ledNled').innerText = `Tipe: ${leds.nama_led}`;
                document.getElementById('ledStatus').innerText = `Status: ${leds.status? 'Aktif' : 'Tidak Aktif'}`;
            });

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
                    const latestData = sensorData[0];
                    const gasLevel = latestData.gas_level;
                    const rainDetected = latestData.rain_detected ? 1 : 0;
                    document.getElementById('temperature').innerText = latestData.temperature;
                    document.getElementById('humidity').innerText = latestData.humidity + '%';

                    const gasGauge = new JustGage({
                        id: "gasGauge",
                        value: gasLevel,
                        min: 0,
                        max: 1000,
                        title: "Gas Level",
                        label: "ppm",
                        levelColors: ["#00ff00", "#ff0000"]
                    });

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
