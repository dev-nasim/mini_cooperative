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
                                    <a href="#">Deposit List</a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('deposit.create') }}" class="btn btn-primary">
                            <i class="gd gd-plus"></i> Add New
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('deposit.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive-xl">
                    <table class="table text-nowrap mb-0 table-bordered">
                        <thead>
                        <tr>
                            <th class="font-weight-semi-bold border-top-0 py-2">#</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Member</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Saving Code</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Cooperative</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Groups</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Deposit</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $index => $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->member_name }}[{{$d->m_code}}]</td>
                                <td>{{ $d->saving_code }}</td>
                                <td>{{ $d->cooperative_name }}</td>
                                <td>{{ $d->group_name }}</td>
                                <td>{{ $d->amount }}</td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <form action="{{ route('deposit.destroy', $d->id) }}" method="POST" style="display: inline;" class="delete-form">
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
