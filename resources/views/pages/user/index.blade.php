@extends('layouts.dashboard')

@section('content')
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title">User List</h4>
            </div>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal"><i class="las la-plus"></i>
                Tambah</button>
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid"
                    aria-describedby="user-list-page-info">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Join Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y, H:i:s') }}</td>
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

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="addName">Nama</label>
                            <input type="text" class="form-control" id="addName" name="name">
                          </div>
                          <div class="form-group">
                            <label for="addEmail">Email</label>
                            <input type="email" class="form-control" id="addEmail" name="email">
                          </div>
                          <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input type="password" class="form-control" id="addPassword" name="password">
                          </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
