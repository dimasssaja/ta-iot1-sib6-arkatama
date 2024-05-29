@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/char.css">
    <link rel="icon" href="images/logo.svg" type="image/icon type">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>

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
            <div class="box3">
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
    <canvas id="myChart" style="width:1000px;max-width:900px"></canvas>
    <script>
        const xValues = [1,2,3,4,5,6,7];

        new Chart("myChart", {
          type: "line",
          data: {
            labels: xValues,
            datasets: [{
                label: 'Temperature (°C)',
                data: [31, 35, 45, 32, 20, 30, 45],
                borderColor: 'rgba(255, 99, 132, 1)',
            }, {
                label: 'Humidity',
                data: [65, 59, 80, 81, 56, 55, 40],
                borderColor: 'rgba(54, 162, 235, 1)',
            }]
          },
          options: {
            legend: {display: false}
          }
        });
        </script>

</body>
</html>
@endsection
