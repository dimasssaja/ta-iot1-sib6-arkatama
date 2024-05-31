@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
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
</body>
</html>
@endsection
