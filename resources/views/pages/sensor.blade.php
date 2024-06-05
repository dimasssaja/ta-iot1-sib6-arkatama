@extends('layouts.dashboard')

@section('content')
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

        <div class="box2-sensor">
            <h2>Gas Sensor</h2>
            <div id="gasGauge" class="gauge-container"></div>
        </div>
        <div class="box3-sensor">
            <h2>Rain Sensor</h2>
            <div id="rainGauge" class="gauge-container"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.9/justgage.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            async function fetchData() {
                const response = await fetch('{{ url('api/sensor') }}');
                const result = await response.json();
                return result.data.slice(0, 5);
            }

            let temperatureChart, humidityChart;

            async function updateCharts() {
                const sensorData = await fetchData();
                const labels = sensorData.map(sensor => new Date(sensor.created_at).toLocaleString());
                const temperatureData = sensorData.map(sensor => parseFloat(sensor.temperature).toFixed(1)); // Ensure 1 decimal place
                const humidityData = sensorData.map(sensor => sensor.humidity);

                const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
                if (temperatureChart) {
                    temperatureChart.destroy();
                }
                temperatureChart = new Chart(ctxTemperature, {
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
                if (humidityChart) {
                    humidityChart.destroy();
                }
                humidityChart = new Chart(ctxHumidity, {
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
            }

            // Update charts every 5 seconds
            setInterval(updateCharts, 5000);
            // Update charts when the page first loads
            updateCharts();

            async function fetchSensorData() {
                const response = await fetch('{{ url('api/sensor') }}');
                const result = await response.json();
                return result.data;
            }

            fetchSensorData().then(sensorData => {
                if (sensorData.length > 0) {
                    const latestData = sensorData[0]; // Get the latest data
                    const gasLevel = latestData.gas_level;
                    const rainDetected = latestData.rain_detected ? 1 : 0;

                    // Create gauge for Gas Sensor
                    const gasGauge = new JustGage({
                        id: "gasGauge",
                        value: gasLevel,
                        min: 0,
                        max: 1000,
                        title: "Gas Level",
                        label: "ppm",
                        levelColors: ["#00ff00", "#ff0000"]
                    });

                    // Create gauge for Rain Sensor
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
