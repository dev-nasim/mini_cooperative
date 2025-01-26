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
                                    <a href="#">Member</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Member List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('member.create') }}" class="btn btn-primary">
                            <i class="gd gd-plus"></i> Add New
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('member.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by name,phone,nid or code" value="{{ request('search') }}">
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
                            <th class="font-weight-semi-bold border-top-0 py-2">Name</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">NID/Phone</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Gender</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Spouse</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Cooperative</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Group</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Status</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $index => $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d['name'] }} [{{ $d['m_code'] }}]</td>
                                <td>{{ $d['m_nid']}} / {{$d['m_phone'] }}</td>
                                <td>{{ $d['gender'] == 1 ? 'Male' : 'Female' }}</td>
                                <td>{{ $d['spouse_name'] }} ({{ $d['spouse_relation'] }})</td>
                                <td>{{ $d['cooperative']['name'] ?? 'N/A' }}</td>
                                <td>{{ $d['group']['name'] ?? 'N/A' }}</td>
                                <td>
                                    @if($d['status'] == 1)
                                        <span class="badge badge-pill badge-success">Active</span>
                                    @else
                                        <span class="badge badge-pill badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="position-relative">
                                        <a href="{{ route('member.edit', $d['id']) }}" class="link-dark d-inline-block" title="Edit User">
                                            <i class="gd-pencil icon-text"></i>
                                        </a>

                                        <form action="{{ route('member.destroy', $d['id']) }}" method="POST" style="display: inline;" class="delete-form">
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
                <div class="card-footer d-block d-md-flex align-items-center d-print-none">
                    <div class="d-flex mb-2 mb-md-0">
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} Entries
                    </div>

                    <nav class="d-flex ml-md-auto d-print-none" aria-label="Pagination">
                        <ul class="pagination justify-content-center font-weight-semi-bold mb-0">
                            <!-- Previous Page Link -->
                            @if($data->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="gd-angle-left icon-text icon-text-xs d-inline-block"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                                        <i class="gd-angle-left icon-text icon-text-xs d-inline-block"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- Next Page Link -->
                            @if($data->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                                        <i class="gd-angle-right icon-text icon-text-xs d-inline-block"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="gd-angle-right icon-text icon-text-xs d-inline-block"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
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
