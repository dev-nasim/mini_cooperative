@extends('index')

@section('content')
    <div class="py-4 px-3 px-md-4">
        <div class="mb-3 mb-md-4 d-flex justify-content-between">
            <div class="h3 mb-0">Dashboard</div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card flex-row align-items-center p-3 p-md-4">
                    <div class="icon icon-lg bg-soft-primary rounded-circle mr-3">
                        <i class="icon-text d-inline-block text-primary"></i>
                    </div>
                    <div>
                        <h4 class="lh-1 mb-1">{{ $cooperatives->count() }}</h4>
                        <h6 class="mb-0">Total Cooperatives</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card flex-row align-items-center p-3 p-md-4">
                    <div class="icon icon-lg bg-soft-primary rounded-circle mr-3">
                        <i class="gd gd-group d-inline-block text-primary"></i>
                    </div>
                    <div>
                        <h4 class="lh-1 mb-1">{{ $groups->count() }}</h4>
                        <h6 class="mb-0">Total Groups</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card flex-row align-items-center p-3 p-md-4">
                    <div class="icon icon-lg bg-soft-primary rounded-circle mr-3">
                        <i class="gd gd-group d-inline-block text-primary"></i>
                    </div>
                    <div>
                        <h4 class="lh-1 mb-1">{{ $totalMember }}</h4>
                        <h6 class="mb-0">Total Active Member</h6>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 col-xl-6 mb-3 mb-xl-6">
                <div class="table-responsive-xl">
                    <table class="table text-nowrap mb-0 table-bordered">
                        <thead class="bg-light">
                        <tr>
                            <th class="font-weight-semi-bold border-top-0 py-2">Cooperative Name</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Total Saving</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Total Withdraw</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Sub Total Saving</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cooperativeTransactions as $transaction)
                            <tr>
                                <td class="py-3">{{ $transaction['cooperative_name'] }}</td>
                                <td class="align-middle py-3">{{ $transaction['saving'] }}</td>
                                <td class="py-3">{{ $transaction['withdraw'] }}</td>
                                <td>{{ $transaction['saving'] - $transaction['withdraw'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="py-2">Total</th>
                            <th class="py-2">
                                {{ $cooperativeTransactions->sum('saving') }}
                            </th>
                            <th class="py-2">
                                {{ $cooperativeTransactions->sum('withdraw') }}
                            </th>
                            <th class="py-2">
                                {{ $cooperativeTransactions->sum('saving') - $cooperativeTransactions->sum('withdraw') }}
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-6 col-xl-6 mb-3 mb-xl-6">
                <div class="table-responsive-xl">
                    <table class="table text-nowrap mb-0 table-bordered">
                        <thead class="bg-light">
                        <tr>
                            <th class="font-weight-semi-bold border-top-0 py-2">Group Name</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Group Total Saving</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Group Total Withdraw</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Last Group Total Saving</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groupTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction['group_name'] }}</td>
                                <td>{{ $transaction['saving'] }}</td>
                                <td>{{ $transaction['withdraw'] }}</td>
                                <td>{{ $transaction['saving'] - $transaction['withdraw'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-light">
                            <th class="py-2">Total</th>
                            <th class="py-2">
                                {{ $groupTransactions->sum('saving') }}
                            </th>
                            <th class="py-2">
                                {{ $groupTransactions->sum('withdraw') }}
                            </th>
                            <th class="py-2">
                                {{ $groupTransactions->sum('saving') - $groupTransactions->sum('withdraw') }}
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
