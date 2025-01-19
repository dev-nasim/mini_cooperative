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
                            <a href="{{ route('member.index') }}">Member</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($data) ? 'Edit' : 'Create New' }}
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ isset($data) ? route('member.update', $data->id) : route('member.store') }}" method="POST">
                    @csrf
                    @if(isset($data))
                        @method('PUT')
                    @endif
                    <div class="form-row">
                        <div class="form-group col-12 col-md-4">
                            <label for="coop_id">Cooperative</label>
                            <select class="form-control" id="coop_id" name="coop_id" required>
                                <option value="">Select a Cooperative</option>
                                @foreach ($cooperative as $coop_data)
                                    <option value="{{ $coop_data->id }}"
                                        {{ old('coop_id', $data->coop_id ?? '') == $coop_data->id ? 'selected' : '' }}>
                                        {{ $coop_data->name }} [{{ $coop_data->code }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('coop_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="group_id">Group</label>
                            <select class="form-control" id="group_id" name="group_id" required>
                                <option value="">Select a Group</option>
                                @foreach ($group as $group_data)
                                    <option value="{{ $group_data->id }}"
                                        {{ old('group_id', $data->group_id ?? '') == $group_data->id ? 'selected' : '' }}>
                                        {{ $group_data->name }}[{{ $group_data->code }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('group_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="name">Member Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $data->name ?? '') }}" required>
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="m_code">Member Code</label>
                            <input type="text" class="form-control" id="m_code" name="m_code" placeholder="Member Code" value="{{ old('m_code', $data->m_code ?? '') }}" required readonly>
                            @error('m_code')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="m_nid">Member NID</label>
                            <input type="text" class="form-control" id="m_nid" name="m_nid" placeholder="NID" value="{{ old('m_nid', $data->m_nid ?? '') }}" required>
                            @error('m_nid')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="1" {{ old('gender', $data->gender ?? '') == 1 ? 'selected' : '' }}>Male</option>
                                <option value="2" {{ old('gender', $data->gender ?? '') == 2 ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="m_phone">Phone</label>
                            <input type="text" class="form-control" id="m_phone" name="m_phone" placeholder="Phone" value="{{ old('m_phone', $data->m_phone ?? '') }}" required>
                            @error('m_phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="spouse_name">Spouse Name</label>
                            <input type="text" class="form-control" id="spouse_name" name="spouse_name" placeholder="Spouse Name" value="{{ old('spouse_name', $data->spouse_name ?? '') }}" required>
                            @error('spouse_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="spouse_relation">Relation</label>
                            <select class="form-control" id="spouse_relation" name="spouse_relation" required>
                                <option value="">Select Relation</option>
                                <option value="Father" {{ old('spouse_relation', $data->spouse_relation ?? '') == 'Father' ? 'selected' : '' }}>Father</option>
                                <option value="Mother" {{ old('spouse_relation', $data->spouse_relation ?? '') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                <option value="Husband" {{ old('spouse_relation', $data->spouse_relation ?? '') == 'Husband' ? 'selected' : '' }}>Husband</option>
                                <option value="Wife" {{ old('spouse_relation', $data->spouse_relation ?? '') == 'Wife' ? 'selected' : '' }}>Wife</option>
                            </select>
                            @error('spouse_relation')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address" required>{{ old('address', $data->address ?? '') }}</textarea>
                            @error('address')
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
            const coopSelect = document.getElementById('coop_id');
            const groupSelect = document.getElementById('group_id');
            const memberCodeInput = document.getElementById('m_code');

            coopSelect.addEventListener('change', function() {
                const coopId = this.value;
                if (coopId) {
                    fetch(`/get-groups-by-cooperative/${coopId}`)
                        .then(response => response.json()).then(data => {
                            groupSelect.innerHTML = '<option value="">Select a Group</option>';
                            data.forEach(group => {
                                const option = document.createElement('option');
                                option.value = group.id;
                                option.textContent = `${group.name} [${group.code}]`;
                                groupSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching groups:', error);
                        });
                } else {
                    groupSelect.innerHTML = '<option value="">Select a Group</option>';
                }
            });

            // Generate member code based on selected group
            groupSelect.addEventListener('change', function() {
                const groupId = this.value;
                if (groupId) {
                    fetch(`/get-group-details/${groupId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.group_code) {
                                const nextSerial = data.next_serial ? data.next_serial : 1;
                                const formattedSerial = String(nextSerial).padStart(2, '0');
                                memberCodeInput.value = `${data.group_code}-${formattedSerial}`;
                            } else {
                                alert('Error fetching group details.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>


@endsection
