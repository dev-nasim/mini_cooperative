@extends('index')

@section('content')
    <div class="py-4 px-3 px-md-4">
        <div class="card mb-3 mb-md-4">
            <div class="card-body">
                <!-- Form for Filtering by Year -->
                <form method="GET" action="" class="mb-3">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="year" class="form-control">
                                @php
                                    $currentYear = date('Y');
                                    $years = range($currentYear - 10, $currentYear);
                                @endphp
                                <option value="">Select Year</option>
                                @foreach($years as $yearOption)
                                    <option value="{{ $yearOption }}" @if(request('year') == $yearOption) selected @endif>{{ $yearOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="group" class="form-control">
                                @php
                                    $groups = \App\Models\Group::all();
                                @endphp
                                <option value="">All Groups</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>

                @if (!empty($report))
                    <!-- Show Data Table Only If Report Exists -->
                    <div class="table-responsive-xl">
                        <table class="table text-nowrap mb-0 table-bordered">
                            <thead class="bg-light">
                            <tr>
                                <th class="text-center" colspan="5">Personal Info</th>
                                <th class="text-center" colspan="13">Monthly Report</th>
                                <th class="text-center" colspan="4">Additional Info</th>
                            </tr>
                            <tr>
                                <th>Sl</th>
                                <th>Group Sl</th>
                                <th>Group Name</th>
                                <th>Member Name</th>
                                <th>Spouse Name</th>
                                <th>{{ request('year') - 1 }}</th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Aug</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dec</th>
                                <th>Total</th>
                                <th>Withdraw</th>
                                <th>Balance</th>
                                <th>Group Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                // Initialize grand totals
                                $grandTotalPreviousYear = 0;
                                $grandTotalDeposit = 0;
                                $grandTotalWithdraw = 0;
                                $grandTotalBalance = 0;
                                $grandTotalMonthly = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
                            @endphp

                            @php $sl = 1; @endphp
                            @php $groupSerial = 1; @endphp

                            @foreach($report as $groupId => $group)
                                @php
                                    $groupRowspan = count($group['members']);
                                    $groupPreviousYearTotal = 0;
                                    $groupMonthlyTotals = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
                                    $groupTotalDeposit = 0;
                                    $groupTotalWithdraw = 0;
                                    $groupBalance = 0;
                                @endphp

                                @foreach($group['members'] as $memberName => $member)
                                    @php
                                        $groupPreviousYearTotal += $member['previous_year_balance'];
                                        $groupTotalDeposit += $member['total_deposit'];
                                        $groupTotalWithdraw += $member['total_withdraw'];
                                        $groupBalance += $member['balance'];

                                        foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month) {
                                            $groupMonthlyTotals[$month] += $member['months'][$month]['deposit'] ?? 0;
                                        }
                                    @endphp
                                    <tr>
                                        <th class="bg-light">{{ $sl++ }}</th>
                                        @if ($loop->first)
                                            <td class="align-middle" rowspan="{{ $groupRowspan }}">{{ $groupSerial }}</td>
                                            <td class="align-middle" rowspan="{{ $groupRowspan }}">{{ $group['group_name'] }}</td>
                                        @endif
                                        <td>{{ $memberName }}</td>
                                        <td>{{ $member['spouse_name'] }}</td>
                                        <td>{{ $member['previous_year_balance'] }}</td>

                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                            <td>{{ $member['months'][$month]['deposit'] ?? 0 }}</td>
                                        @endforeach
                                        <td>{{ $member['total_deposit'] }}</td>
                                        <td>{{ $member['total_withdraw'] }}</td>
                                        <td>{{ $member['balance'] }}</td>

                                        @if ($loop->first)
                                            <td class="align-middle" rowspan="{{ $groupRowspan }}">{{ $group['group_total'] }}</td>
                                        @endif
                                    </tr>
                                @endforeach

                                <!-- Group Totals Row -->
                                <tr class="bg-light">
                                    <td colspan="5" class="text-center"><strong>Group Totals</strong></td>
                                    <td><strong>{{ $groupPreviousYearTotal }}</strong></td>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                        <td><strong>{{ $groupMonthlyTotals[$month] }}</strong></td>
                                    @endforeach
                                    <td><strong>{{ $groupTotalDeposit }}</strong></td>
                                    <td><strong>{{ $groupTotalWithdraw }}</strong></td>
                                    <td><strong>{{ $groupBalance }}</strong></td>
                                    <td></td>
                                </tr>

                                @php
                                    // Add group totals to grand totals
                                    $grandTotalPreviousYear += $groupPreviousYearTotal;
                                    $grandTotalDeposit += $groupTotalDeposit;
                                    $grandTotalWithdraw += $groupTotalWithdraw;
                                    $grandTotalBalance += $groupBalance;

                                    foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month) {
                                        $grandTotalMonthly[$month] += $groupMonthlyTotals[$month];
                                    }
                                @endphp

                                @php $groupSerial++; @endphp
                            @endforeach

                            <!-- Grand Totals Row -->
                            <tr class="bg-warning">
                                <td colspan="5" class="text-center"><strong>Grand Total</strong></td>
                                <td><strong>{{ $grandTotalPreviousYear }}</strong></td>
                                @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <td><strong>{{ $grandTotalMonthly[$month] }}</strong></td>
                                @endforeach
                                <td><strong>{{ $grandTotalDeposit }}</strong></td>
                                <td><strong>{{ $grandTotalWithdraw }}</strong></td>
                                <td><strong>{{ $grandTotalBalance }}</strong></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Message for No Data -->
                    <div class="alert alert-info">
                        Please select a year to view the deposit report.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
