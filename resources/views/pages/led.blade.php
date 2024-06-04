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
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leds as $led)
                            <tr>
                                <td>{{ $led->id }}</td>
                                <td>{{ $led->nama_led }}</td>
                                <td><span id="status-table-{{ $led->id }}">{{ $led->status }}</span></td>
                                <td>{{ $led->user_id }}</td>
                                <td>{{ $led->created_at->format('d M Y, H:i:s') }}</td>
                                <td>{{ $led->updated_at->format('d M Y, H:i:s') }}</td>
                                {{-- <td>
                                    <div class="flex align-items-center list-user-action">
                                        <a data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Edit" href="#"><i class="ri-pencil-line"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Delete" href="#"><i
                                                class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah LED</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="addNama">Nama LED</label>
                            <input required type="text" class="form-control" id="addNama" name="nama_led">
                        </div>
                        <div class="form-group">
                            <label for="addStatus">Status</label>
                            <input type="checkbox" class="form-control" id="addStatus" name="status">
                        </div>
                        <div class="form-group">
                            <label for="addUser">User ID</label>
                            <input required type="number" class="form-control" id="addUser" name="user_id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="createLed()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard">
        <div class="devices">
            <div class="row1">
                @foreach ($leds as $led)
                    <div class="box">
                        <p>{{ $led->nama_led }}</p>
                        <p>User: {{ auth()->user()->name }} </p>
                        <p>Status: <span id="status-box-{{ $led->id }}">{{ $led->status }}</span></p>
                        <img src="images/light.svg" alt="light" id="lightimg{{ $led->id }}">
                        <i class="fas fa-lightbulb-on light" id="lighton{{ $led->id }}"
                            style="width: 25px; height: 25px; color: yellow"></i>
                        <label class="switch">
                            <input type="checkbox" id="lightswitch{{ $led->id }}"
                                onchange="toggleLight({{ $led->id }})" {{ $led->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleLight(id) {
            const isActive = $('#lightswitch' + id).is(':checked');
            const status = isActive ? 1 : 0;
            $.ajax({
                url: '/leds/' + id,
                type: 'PUT',
                data: {
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#status-table-' + id).text(status);
                    $('#status-box-' + id).text(status);
                },
                error: function(xhr) {
                    alert('Error updating status');
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let userId = null;
        // toastr.success('dddds')
        $('#addModal').on('show.bs.modal', function(e) {
            $('#addForm').trigger('reset');
            $('#addForm input').removeClass('is-invalid');
            $('#addForm .invalid-feedback').remove();
        })

        function createLed() {
            let data = {
                nama_led: $('#addNama').val(),
                status: $('#addStatus').is(':checked') ? 1 : 0,
                user_id: $('#addUser').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: '/api/leds',
                type: 'POST',
                data: data,
                success: function(response) {
                    toastr.success('LED berhasil ditambahkan');
                    $('#addModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Gagal menambahkan LED');
                }
            });
        }
    </script>
@endsection
