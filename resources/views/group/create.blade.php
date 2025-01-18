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
                            <a href="{{ route('group.index') }}">Group</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($data) ? 'Edit' : 'Create New' }}
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ isset($data) ? route('group.update', $data->id) : route('group.store') }}" method="POST">
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
                            <label for="coop_id">Cooperative</label>
                            <select class="form-control" id="coop_id" name="coop_id" required>
                                <option value="">Select a Cooperative</option>
                                @foreach ($cooperative as $coop_data)
                                    <option value="{{ $coop_data->id }}"
                                        {{ old('coop_id', $data->coop_id ?? '') == $coop_data->id ? 'selected' : '' }}>
                                        {{ $coop_data->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('coop_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="name">Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Group Code" value="{{ old('code', $data->code ?? '') }}" required>
                            @error('code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">{{ isset($data) ? 'Update' : 'Submit' }}</button>
                </form>

            </div>
        </div>
    </div>
@endsection
