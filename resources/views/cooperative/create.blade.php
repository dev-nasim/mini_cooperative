@extends('index')

@section('content')
    <div class="py-4 px-3 px-md-4">
        <div class="card mb-3 mb-md-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
                            <a href="{{ route('cooperative.index') }}">Cooperative</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($data) ? 'Edit' : 'Create New' }}
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ isset($data) ? route('cooperative.update', $data->id) : route('cooperative.store') }}" method="POST">
                    @csrf
                    @if(isset($data))
                        @method('PUT')
                    @endif

                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $data->name ?? '') }}" required>
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="name">Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Code" value="{{ old('code', $data->code ?? '') }}" required>
                            @error('code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="contact_person">Contact Person Name</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person Name" value="{{ old('contact_person', $data->contact_person ?? '') }}">
                            @error('contact_person')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="address">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Mobile/Phone Number" value="{{ old('contact', $data->contact ?? '') }}">
                            @error('contact')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">{{ isset($data) ? 'Update' : 'Save' }}</button>
                </form>

            </div>
        </div>
    </div>
@endsection
