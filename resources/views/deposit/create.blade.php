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
                            <a href="{{ route('deposit.index') }}">Deposit</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create New</li>
                    </ol>
                </nav>

                <!-- Form -->
                <form action="{{ route('deposit.store') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-12 col-md-4">
                            <label for="s_account_id">Account</label>
                            <select class="form-control" id="s_account_id" name="s_account_id" required>
                                <option value="">Select an Account</option>
                                @foreach ($accounts as $saving_account)
                                    <option value="{{ $saving_account->id }}">
                                        {{ $saving_account->member_name }} [{{ $saving_account->saving_code }}]
                                    </option>
                                @endforeach
                            </select>
                            @error('s_account_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-4">
                            <label for="deposit_date">Date</label>
                            <input type="date" class="form-control" id="deposit_date" name="deposit_date" value="{{ old('deposit_date') }}" required>
                            @error('deposit_date')
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const savingsSelect = document.getElementById('s_account_id');
            const transactionDetailsContainer = document.getElementById('transactionDetailsContainer');
            const openingDate = document.getElementById('openingDate');
            const totalDeposit = document.getElementById('totalDeposit');
            const totalWithdraw = document.getElementById('totalWithdraw');
            const balance = document.getElementById('balance');

            savingsSelect.addEventListener('change', function () {
                const savingsAccountId = this.value;

                if (savingsAccountId) {
                    fetch(`/get_transactions/${savingsAccountId}`)
                        .then(response => response.json())
                        .then(data => {
                            openingDate.textContent = data.opening_date || '-';
                            totalDeposit.textContent = data.total_deposit || 0;
                            totalWithdraw.textContent = data.total_withdraw || 0;
                            balance.textContent = data.balance || 0;
                            transactionDetailsContainer.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error fetching transaction details:', error);
                            openingDate.textContent = '-';
                            totalDeposit.textContent = '0';
                            totalWithdraw.textContent = '0';
                            balance.textContent = '0';
                            transactionDetailsContainer.style.display = 'none';
                        });
                } else {
                    transactionDetailsContainer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
