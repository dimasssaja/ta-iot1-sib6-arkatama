@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/char.css">
</head>
<body>

    <!-- Line Chart for Temperature -->

    <canvas id="temperatureChart" width="400" height="200"></canvas>

    <!-- Line Chart for Humidity -->

    <canvas id="humidityChart" width="400" height="200"></canvas>


    <div class="header">
    </div>
    <div class="dashboard">
        <div class="mainrow">
            <div class="box2">
                <h2>Gas Sensor</h2>
                <div class="gauge">
                    <div class="gauge__body">
                      <div class="gauge__fill"></div>
                      <div class="gauge__cover">50</div>
                    </div>
                </div>
                <div class="indicator">
                </div>
            </div>
            <div class="box2">
                <h2>Rain Sensor</h2>
                <div class="gauge">
                    <div class="gauge__body">
                      <div class="gauge__cover">0</div>
                    </div>
                </div>
                <div class="indicator">
                </div>
            </div>
        </div>

    <script>
        // Data for the charts
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        const temperatureData = [0, 10, 5, 2, 20, 30, 45];
        const humidityData = [65, 59, 80, 81, 56, 55, 40];
        const gasData = [300];
        const rainData = [150];

        // Line Chart for Temperature
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
                responsive: true
            }
        });

        // Line Chart for Humidity
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
                responsive: true
            }
        });
    </script>
</body>
</html>
@endsection
