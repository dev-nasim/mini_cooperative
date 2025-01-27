@extends('index')

@section('content')
    <div class="py-4 px-3 px-md-4">
        <div class="mb-3 mb-md-4 d-flex justify-content-between">
            <div class="h3 mb-0">Dashboard</div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-6 mb-3 mb-xl-6">
                <div class="table-responsive-xl">
                    <table class="table text-nowrap mb-0 table-bordered">
                        <thead class="bg-light">
                        <tr>
                            <th class="font-weight-semi-bold border-top-0 py-2">Cooperative Name</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Total Withdraw</th>
                            <th class="font-weight-semi-bold border-top-0 py-2">Total Saving</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        @foreach ($cooperativeData as $coop)--}}
{{--                            <tr>--}}
{{--                                <td class="py-3">COOP-{{ $coop->coop_id }}</td>--}}
{{--                                <td class="align-middle py-3">{{ number_format($coop->total_withdraw, 2) }}</td>--}}
{{--                                <td class="py-3">{{ number_format($coop->total_saving, 2) }}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
