@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home</title>
    <link rel="stylesheet" href="css/char.css">
    <link rel="icon" href="images/logo.svg" type="image/icon type">
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
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
                        <strong>24</strong><sup>°C</sup>
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

    <script src="js/smart.js"></script>
</body>
</html>
@endsection
