@extends('layouts.dashboard')

@section('content')
    <!-- Bagian konten dari halaman -->
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between align-items-center">
            <div class="iq-header-title">
                <h4 class="card-title">User List</h4>
            </div>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal">
                <i class="las la-plus"></i> Tambah
            </button> <!-- Tombol untuk membuka modal tambah pengguna -->
        </div>
        <div class="iq-card-body">
            <div class="table-responsive">
                <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid"
                    aria-describedby="user-list-page-info">
                    <thead>
                        <tr>
                            <th>Name</th> <!-- Kolom untuk nama pengguna -->
                            <th>Email</th> <!-- Kolom untuk email pengguna -->
                            <th>Role</th> <!-- Kolom untuk peran pengguna -->
                            <th>Join Date</th> <!-- Kolom untuk tanggal bergabung -->
                            <th>Action</th> <!-- Kolom untuk tindakan (edit/hapus) -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <!-- Looping untuk setiap pengguna -->
                            <tr>
                                <td>{{ $user->name }}</td> <!-- Menampilkan nama pengguna -->
                                <td>{{ $user->email }}</td> <!-- Menampilkan email pengguna -->
                                <td>
                                    @if ($user->role == 'admin')
                                        <!-- Mengecek peran pengguna -->
                                        <span class="badge badge-primary">
                                            <i class="ri-user-star-fill"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="ri-user-fill"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y, H:i:s') }}</td>
                                <!-- Menampilkan tanggal bergabung -->
                                <td>
                                    <div class="flex align-items-center list-user-action">
                                        <a onclick="openEditModal('{{ $user->id }}')" data-toggle="tooltip"
                                            data-placement="top" title="Edit" href="#"><i
                                                class="ri-pencil-line"></i></a> <!-- Tautan untuk mengedit pengguna -->
                                        <a onclick="deleteUser('{{ $user->id }}')" data-toggle="tooltip"
                                            data-placement="top" title="Delete" href="#"><i
                                                class="ri-delete-bin-line"></i></a> <!-- Tautan untuk menghapus pengguna -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah pengguna -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pengguna</h5> <!-- Judul modal -->
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
                            <label for="addRole">Role</label>
                            <select class="form-control" id="addRole" name="role">
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
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

    <!-- Modal untuk mengedit pengguna -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Update Pengguna</h5> <!-- Judul modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input required type="text" class="form-control is-invalid" id="editName"
                                name="name">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input required type="email" class="form-control" id="editEmail" name="email">
                        </div>

                        <div class="form-group">
                            <label for="editRole">Role</label>
                            <select class="form-control" id="editRole" name="role">
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
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
    <!-- Menambahkan script ke dalam stack 'scripts' -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Mengimpor pustaka SweetAlert2 -->
    <script>
        let userId = null; // Variabel untuk menyimpan ID pengguna yang sedang diedit

        // Reset form ketika modal tambah pengguna ditampilkan
        $('#addModal').on('show.bs.modal', function(e) {
            $('#addForm').trigger('reset');
            $('#addForm input').removeClass('is-invalid');
            $('#addForm .invalid-feedback').remove();
        })

        // Reset form ketika modal edit pengguna ditampilkan
        $('#editModal').on('show.bs.modal', function(e) {
            $('#editForm input').removeClass('is-invalid');
            $('#editForm .invalid-feedback').remove();
        })

        // Fungsi untuk membuat pengguna baru
        function createUser() {
            const url = "{{ route('api.users.store') }}"; // URL endpoint untuk menyimpan pengguna baru
            let data = {
                name: $('#addName').val(),
                email: $('#addEmail').val(),
                password: $('#addPassword').val(),
                role: $('#addRole').val()
            }

            $.post(url, data)
                .done((response) => {
                    toastr.success(response.message, 'Sukses') // Menampilkan notifikasi sukses

                    setTimeout(() => {
                        location.reload() // Memuat ulang halaman setelah 3 detik
                    }, 3000);
                })
                .fail((error) => {
                    let response = error.responseJSON
                    toastr.error(response.message, 'Error') // Menampilkan notifikasi error

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

                            input.after(feedbackElement) // Menampilkan pesan kesalahan di bawah input yang sesuai
                        }
                    }
                })
        }

        // Fungsi untuk mengedit pengguna
        function editUser() {
            let url = "{{ route('api.users.update', ':userId') }}";
            url = url.replace(':userId', userId); // Mengganti placeholder dengan ID pengguna yang sedang diedit

            let data = {
                name: $('#editName').val(),
                email: $('#editEmail').val(),
                password: $('#editPassword').val(),
                role: $('#editRole').val(),
                _method: 'PUT'
            }

            $.post(url, data)
                .done((response) => {
                    toastr.success(response.message, 'Sukses') // Menampilkan notifikasi sukses

                    setTimeout(() => {
                        location.reload() // Memuat ulang halaman setelah 1 detik
                    }, 1000);
                })
                .fail((error) => {
                    let response = error.responseJSON
                    toastr.error(response.message, 'Error') // Menampilkan notifikasi error

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

                            input.after(feedbackElement) // Menampilkan pesan kesalahan di bawah input yang sesuai
                        }
                    }
                })
        }

        // Fungsi untuk menghapus pengguna
        function deleteUser(userId) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'User akan dihapus, kamu tidak bisa mengembalikannya lagi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('api.users.destroy', ':userId') }}";
                    url = url.replace(':userId',
                    userId); // Mengganti placeholder dengan ID pengguna yang akan dihapus

                    $.post(url, {
                            _method: 'DELETE'
                        })
                        .done((response) => {
                            toastr.success(response.message, 'Sukses') // Menampilkan notifikasi sukses

                            setTimeout(() => {
                                location.reload() // Memuat ulang halaman setelah 1 detik
                            }, 1000);
                        })
                        .fail((error) => {
                            toastr.error('Gagal menghapus user', 'Error') // Menampilkan notifikasi error
                        })
                }
            })
        }

        // Fungsi untuk membuka modal edit pengguna
        function openEditModal(id) {
            userId = id; // Menyimpan ID pengguna yang sedang diedit

            let url = '{{ route('api.users.show', ':userId') }}';
            url = url.replace(':userId', userId); // Mengganti placeholder dengan ID pengguna yang akan diambil datanya

            $.get(url)
                .done((response) => {
                    $('#editName').val(response.data.name);
                    $('#editEmail').val(response.data.email);
                    $('#editRole').val(response.data.role);

                    $('#editModal').modal('show'); // Menampilkan modal edit pengguna
                })
                .fail((error) => {
                    toastr.error('Gagal mengambil data user', 'Error') // Menampilkan notifikasi error
                })
        }
    </script>
@endpush
