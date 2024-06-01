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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>
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
            <div class="box2-sensor">
                <h2>Gas Sensor</h2>
                <div id="gasGauge" class="gauge-container">
                    <div class="">
                    </div>
                </div>
                {{-- <div class="indicator">
            <h4>bahaya</h4>
        </div> --}}
            </div>
            <div class="box3-sensor">
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

            <script src="js/smart.js"></script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    async function fetchData() {
                        const response = await fetch('{{ url('api/sensor') }}');
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
