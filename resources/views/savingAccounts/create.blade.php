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
                            <a href="{{ route('saving_accounts.index') }}">Account</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($data) ? 'Edit' : 'Create New' }}
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ isset($data) ? route('saving_accounts.update', $data->id) : route('saving_accounts.store') }}" method="POST">
                    @csrf
                    @if(isset($data))
                        @method('PUT')
                    @endif
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="member_id">Member</label>
                            <select class="form-control" id="member_id" name="member_id" required>
                                <option value="">Select a Member</option>
                                @foreach ($member as $member_data)
                                    <option value="{{ $member_data->id }}"
                                        {{ old('member_id', $data->member_id ?? '') == $member_data->id ? 'selected' : '' }}>
                                        {{ $member_data->name }}[{{ $member_data->m_code }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="saving_code">Saving Code</label>
                            <input type="text" class="form-control" id="saving_code" name="saving_code" value="{{ old('saving_code', $data->saving_code ?? '') }}" readonly required>
                            @error('saving_code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">{{ isset($data) ? 'Update' : 'Save' }}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const memberSelect = document.getElementById('member_id');
            const savingCodeInput = document.getElementById('saving_code');
            memberSelect.addEventListener('change', function() {
                const memberId = this.value;
                if (memberId) {
                    fetch(`/get-member-details/${memberId}`).then(response => response.json()).then(data => {
                        savingCodeInput.value = `${data.m_code}-${data.saving_serial}`;
                    });
                }
            });
        });
    </script>
@endsection
