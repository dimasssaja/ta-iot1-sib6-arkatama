@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humidity and Temperature Charts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            display: flex;
            justify-content: space-around;
        }
        .chart-box {
            width: 45%;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="chart-container">
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
    </div>

    <style>
        .chart-container {
            display: flex;
            justify-content: space-around;
        }
        .chart-box {
            width: 45%;
        }
    </style>
</head>
<body>

    <div class="header">
    </div>
    <div class="dashboard">
        <div class="mainrow">
            <div class="box2-sensor">
                <h2>Gas Sensor</h2>
                <div class="gauge">
                    <div class="gauge__body">
                      <div class="gauge__fill"></div>
                      <div class="gauge__cover"></div>
                    </div>
                </div>
                <div class="indicator">
                    <h4>bahaya</h4>
                </div>
            </div>
            <div class="box3-sensor">
                <h2>Rain Sensor</h2>
                <div class="gauge">
                    <div class="gauge__body">
                      <div class="gauge__cover">0 </div>
                    </div>
                </div>
                <div class="indicator">
                    <i class="fa-solid fa-cloud-rain">tidak terdeteksi</i>
                </div>
            </div>
        </div>

    <script src="js/smart.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            async function fetchData() {
                const response = await fetch('{{ url("api/sensor") }}');
                const result = await response.json();
                return result.data;
            }

            fetchData().then(sensorData => {
                const labels = sensorData.map(sensor => new Date(sensor.created_at).toLocaleString());
                const temperatureData = sensorData.map(sensor => sensor.temperature);
                const humidityData = sensorData.map(sensor => sensor.humidity);

                const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
                const temperatureChart = new Chart(ctxTemperature, {
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
                            }
                        }
                    }
                });

                const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
                const humidityChart = new Chart(ctxHumidity, {
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
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
@endsection
