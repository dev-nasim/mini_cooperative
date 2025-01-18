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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.index') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($user) ? 'Edit User' : 'Create New User' }}
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                            @error('phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="New Password" value="{{ old('password') }}" @if(!isset($user)) required @endif>
                            @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address" required>{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                </form>

            </div>
        </div>
    </div>
@endsection
