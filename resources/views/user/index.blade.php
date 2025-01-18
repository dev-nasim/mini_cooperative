@extends('index')

@section('content')
    <div class="py-4 px-3 px-md-4">
        <div class="card mb-3 mb-md-4">
            <div class="card-body">
                <!-- Display Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Display Error Message -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Breadcrumb -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <nav class="d-none d-md-block" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Users</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Users List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="gd gd-plus"></i> Add New
                        </a>
                    </div>
                </div>

                <div class="table-responsive-xl">
                    <table class="table text-nowrap mb-0 table-bordered">
                        <thead>
                        <tr>
                            <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Name</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Phone</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Email</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Address</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Status</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $index => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge badge-pill badge-success">Active</span>
                                    @else
                                        <span class="badge badge-pill badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <a href="{{ route('user.edit', $user->id) }}" class="link-dark d-inline-block" title="Edit User">
                                            <i class="gd-pencil icon-text"></i>
                                        </a>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="link-dark d-inline-block" style="background: none; border: none; color: inherit; cursor: pointer;" title="Delete User">
                                                <i class="gd-trash icon-text"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this user?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
