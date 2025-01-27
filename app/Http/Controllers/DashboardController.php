<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Group;
use App\Models\Member;
use App\Models\Transection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $cooperatives = Cooperative::all();
        $groups = Group::all();

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        $cooperativeTransactions = Transection::
//            whereMonth('transaction_date', $currentMonth)
//            ->whereYear('transaction_date', $currentYear)
            get()
            ->groupBy('coop_id')
            ->map(function ($transactions, $coopId) use ($cooperatives) {
                $cooperative = $cooperatives->find($coopId);
                return [
                    'cooperative_name' => $cooperative ? $cooperative->name : 'Unknown Cooperative',
                    'saving' => $transactions->where('type', 1)->sum('amount'),
                    'withdraw' => $transactions->where('type', 2)->sum('amount'),
                ];
            });

        $groupTransactions = Transection::
//            whereMonth('transaction_date', $currentMonth)
//            ->whereYear('transaction_date', $currentYear)
            get()
            ->groupBy('group_id')
            ->map(function ($transactions, $groupId) use ($groups) {
                $group = $groups->find($groupId);
                return [
                    'group_name' => $group ? $group->name : 'Unknown Group',
                    'saving' => $transactions->where('type', 1)->sum('amount'),
                    'withdraw' => $transactions->where('type', 2)->sum('amount'),
                ];
            });

        $totalMember = Member::where('status', 1)->count();
        return view('dashboard', compact('cooperativeTransactions', 'groupTransactions','groups','cooperatives','totalMember'));
    }



}
