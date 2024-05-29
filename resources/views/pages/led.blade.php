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

        <div class="devices">

            <div class="row1">

                <div class="box">
                    <p>LED R</p>
                    <img src="images/light.svg" alt="light" id="lightimg1">
                    <i class="fas fa-lightbulb-on light" id="lighton1" style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch1" onchange="light1()">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="box">
                    <p>LED G</p>
                    <img src="images/light.svg" alt="light" id="lightimg2">
                    <i class="fas fa-lightbulb-on light" id="lighton2" style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch2"  onchange="light2()" >
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="box">
                    <p>LED B</p>
                    <img src="images/light.svg" alt="light" id="lightimg3">
                    <i class="fas fa-lightbulb-on light" id="lighton3" style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch3"  onchange="light3()" >
                        <span class="slider round"></span>
                    </label>
                </div>


            {{-- <div class="row2">
                <div class="box">
                    <p>Living Room</p>
                    <img src="images/fan.svg" alt="light" id="fan1">
                    <label class="switch">
                        <input type="checkbox" id="fanswitch1" onchange="fanrotate1()">
                        <span class="slider round"></span>
                    </label>
                </div> --}}


            </div>
        </div>
    </div>

    <script src="js/smart.js"></script>
</body>
</html>
@endsection
