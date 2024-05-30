@extends('layouts.dashboard')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/char.css">
        <title>Data LED</title>
        <link rel="icon" href="images/logo.svg" type="image/icon type">
        <link href="https://kit-pro.fontawesome.com/releases/v5.15.4/css/pro.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title">Data LED List</h4>
            </div>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal"><i
                    class="las la-plus"></i>
                Tambah</button>
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid"
                    aria-describedby="user-list-page-info">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama LED</th>
                            <th>Status</th>
                            <th>User ID</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leds as $led)
                            <tr>
                                <td>{{ $led->id }}</td>
                                <td>{{ $led->nama_led }}</td>
                                <td>{{ $led->status }}</td>
                                <td>{{ $led->user_id }}</td>
                                <td>{{ $led->created_at->format('d M Y, H:i:s') }}</td>
                                <td>{{ $led->updated_at->format('d M Y, H:i:s') }}</td>
                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        <a data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Delete" href="#"><i
                                                class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <body>
        <div class="container mt-5">
            <h2>Data LED</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama LED</th>
                        <th>Status</th>
                        <th>User ID</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leds as $led)
                        <tr>
                            <td>{{ $led->id }}</td>
                            <td>{{ $led->nama_led }}</td>
                            <td>{{ $led->status }}</td>
                            <td>{{ $led->user_id }}</td>
                            <td>{{ $led->created_at }}</td>
                            <td>{{ $led->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

    <div class="dashboard">

        <div class="devices">

            <div class="row1">

                <div class="box">
                    <p>LED R</p>
                    <img src="images/light.svg" alt="light" id="lightimg1">
                    <i class="fas fa-lightbulb-on light" id="lighton1"
                        style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch1" onchange="light1()">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="box">
                    <p>LED G</p>
                    <img src="images/light.svg" alt="light" id="lightimg2">
                    <i class="fas fa-lightbulb-on light" id="lighton2"
                        style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch2" onchange="light2()">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div class="box">
                    <p>LED B</p>
                    <img src="images/light.svg" alt="light" id="lightimg3">
                    <i class="fas fa-lightbulb-on light" id="lighton3"
                        style="width: 25px; height: 25px; color: yellow"></i>
                    <label class="switch">
                        <input type="checkbox" id="lightswitch3" onchange="light3()">
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
