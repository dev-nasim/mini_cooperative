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
                            <a href="{{ route('withdraw.index') }}">Withdraw</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create New</li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ route('withdraw.store') }}" method="POST">
                    @csrf
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
                            <label for="s_account_id">Account</label>
                            <select class="form-control" id="s_account_id" name="s_account_id" required>
                                <option value="">Select an Account</option>
                            </select>

                            @error('s_account_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="transaction_date">Date</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ old('transaction_date') }}" required>
                            @error('transaction_date')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="form-group col-12" id="transactionDetailsContainer" style="display: none; margin-top: 30px">
                        <h5>Transaction Details</h5>
                        <hr>
                        <p><strong>Opening Date: </strong><span id="openingDate">-</span></p>
                        <p><strong>Total Deposit: </strong><span id="totalDeposit">0</span></p>
                        <p><strong>Total Withdraw: </strong><span id="totalWithdraw">0</span></p>
                        <p><strong>Balance: </strong><span id="balance">0</span></p>
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Save</button>
                </form>
            </div>
            <div class="form-group col-12" id="transactionDetailsContainer" style="display: none; margin-top: 30px">
                <h5>Account Details</h5>
                <hr>
                <p><strong>Opening Date: </strong><span id="openingDate">-</span></p>
                <p><strong>Total Deposit: </strong><span id="totalDeposit">0</span></p>
                <p><strong>Total Withdraw: </strong><span id="totalWithdraw">0</span></p>
                <p><strong>Balance: </strong><span id="balance">0</span></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const memberSelect = document.getElementById('member_id');
            const accountSelect = document.getElementById('s_account_id');
            const transactionDetailsContainer = document.getElementById('transactionDetailsContainer');
            const openingDate = document.getElementById('openingDate');
            const totalDeposit = document.getElementById('totalDeposit');
            const totalWithdraw = document.getElementById('totalWithdraw');
            const balance = document.getElementById('balance');
            const amountInput = document.getElementById('amount');

            memberSelect.addEventListener('change', function () {
                const memberId = this.value;
                accountSelect.innerHTML = '<option value="">Select an Account</option>';
                transactionDetailsContainer.style.display = 'none';
                amountInput.value = '';
                amountInput.max = '';

                if (memberId) {
                    fetch(`/get_saving_account/${memberId}`).then(response => response.json()).then(data => {
                        if (data.success && Array.isArray(data.accounts)) {
                            accountSelect.innerHTML = '<option value="">Select an Account</option>';
                            data.accounts.forEach(account => {
                                const option = document.createElement('option');
                                option.value = account.id;
                                option.textContent = `${account.saving_code}`;
                                accountSelect.appendChild(option);
                            });
                        } else {
                            alert(data.message || 'No accounts found.');
                        }
                    });
                }
            });

            accountSelect.addEventListener('change', function () {
                const accountId = this.value;
                transactionDetailsContainer.style.display = 'none';
                if (accountId) {
                    fetch(`/get_account_details/${accountId}`).then(response => response.json()).then(data => {
                        if (data.success) {
                            openingDate.textContent = data.details.opening_date || '-';
                            totalDeposit.textContent = data.details.total_deposit || 0;
                            totalWithdraw.textContent = data.details.total_withdraw || 0;
                            balance.textContent = data.details.balance || 0;
                            const availableBalance = data.details.balance || 0;
                            amountInput.value = availableBalance;
                            amountInput.max = availableBalance;
                            transactionDetailsContainer.style.display = 'block';
                        } else {
                            alert(data.message || 'Failed to fetch account details.');
                        }
                    });
                }
            });

            amountInput.addEventListener('input', function () {
                const availableBalance = parseFloat(balance.textContent) || 0;
                const enteredAmount = parseFloat(amountInput.value) || 0;
                if (enteredAmount > availableBalance) {
                    alert('Amount cannot exceed available balance.');
                    amountInput.value = availableBalance;
                } else {
                    amountInput.setCustomValidity('');
                }
            });
        });

    </script>
@endsection
