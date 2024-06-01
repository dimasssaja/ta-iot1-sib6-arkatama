@extends('layouts.dashboard')

@section('content')
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title">User List</h4>
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
                                        <a onclick="openEditModal('{{ $user->id }}')" data-toggle="tooltip"
                                            data-placement="top" title="" data-original-title="Edit" href="#"><i
                                                class="ri-pencil-line"></i></a>
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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="addName">Nama</label>
                            <input required type="text" class="form-control is-invalid" id="addName" name="name">
                        </div>
                        <div class="form-group">
                            <label for="addEmail">Email</label>
                            <input required type="email" class="form-control" id="addEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input required type="password" class="form-control" id="addPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="createUser()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Update Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input required type="text" class="form-control is-invalid" id="editName" name="name">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input required type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="editPassword">Password</label>
                            <input required type="password" class="form-control" id="editPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="editUser()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let userId = null;
        // toastr.success('dddds')
        $('#addModal').on('show.bs.modal', function(e) {
            $('#addForm').trigger('reset');
            $('#addForm input').removeClass('is-invalid');
            $('#addForm .invalid-feedback').remove();
        })

        $('#addModal').on('show.bs.modal', function(e) {
            $('#editForm input').removeClass('is-invalid');
            $('#editForm .invalid-feedback').remove();
        })

        function createUser() {
            const url = "{{ route('api.users.store') }}";
            let data = {
                name: $('#addName').val(),
                email: $('#addEmail').val(),
                password: $('#addPassword').val(),
            }

            $.post(url, data)
                .done((response) => {
                    toastr.success(response.message, 'Sukses')

                    setTimeout(() => {
                        location.reload()
                    }, 3000);
                })
                .fail((error) => {
                    let response = error.responseJSON
                    toastr.error(response.message, 'Error')

                    if (response.errors) {

                        for (const error in response.errors) {
                            let input = $('#addForm input[name="${error}"]')
                            input.addClass('is-invalid');

                            let feedbackElement = '<div class="invalid-feedback">'
                            feedbackElement += '<ul class="list-unstyled">'
                            response.errors[error].forEach((message) => {
                                feedbackElement += '<li>${message}</li>'
                            })
                            feedbackElement += '</ul>'
                            feedbackElement += '</div>'

                            input.after(feedbackElement)
                        }
                    }
                })
        }

        function editUser() {
            let url = "{{ route('api.users.update', ':userId') }}";
            url = url.replace(':userId', userId);


            let data = {
                name: $('#editName').val(),
                email: $('#editEmail').val(),
                password: $('#editPassword').val(),
                _method: 'PUT'
            }

            $.post(url, data)
                .done((response) => {
                    toastr.success(response.message, 'Sukses')

                    setTimeout(() => {
                        location.reload()
                    }, 3000);
                })
                .fail((error) => {
                    let response = error.responseJSON
                    toastr.error(response.message, 'Error')

                    if (response.errors) {

                        for (const error in response.errors) {
                            let input = $('#editForm input[name="${error}"]')
                            input.addClass('is-invalid');

                            let feedbackElement = '<div class="invalid-feedback">'
                            feedbackElement += '<ul class="list-unstyled">'
                            response.errors[error].forEach((message) => {
                                feedbackElement += '<li>${message}</li>'
                            })
                            feedbackElement += '</ul>'
                            feedbackElement += '</div>'

                            input.after(feedbackElement)
                        }
                    }
                })
        }

        function deleteUser() {

        }

        function openEditModal(id) {

            userId = id;

            let url = '{{ route('api.users.show', ':userId') }}';
            url = url.replace(':userId', userId);

            $.get(url)
                .done((response) => {
                    $('#editName').val(response.data.name);
                    $('#editEmail').val(response.data.email);

                    $('#editModal').modal('show');
                })
                .fail((error) => {
                    toastr.error('Gagal mengambil data user', 'Error')
                })
        }
    </script>
@endpush
