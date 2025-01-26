<?php

namespace App\Http\Controllers;

use App\Models\Transection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function depositReport(Request $request)
    {
        $year = $request->input('year'); // Get the selected year
        $group = $request->input('group'); // Get the selected year
        $report = []; // Default empty report

        if ($year) {
            // Fetch data for the selected year
            $data = DB::table('transections')
                ->join('members', 'transections.member_id', '=', 'members.id')
                ->join('groups', 'members.group_id', '=', 'groups.id')
                ->select(
                    'groups.id as group_id',
                    'groups.name as group_name',
                    'members.id as member_id',
                    'members.name as member_name',
                    'members.spouse_name',
                    DB::raw("SUM(CASE WHEN transections.type = 1 THEN transections.amount ELSE 0 END) as total_deposit"),
                    DB::raw("SUM(CASE WHEN transections.type = 2 THEN transections.amount ELSE 0 END) as total_withdraw"),
                    DB::raw("SUM(CASE WHEN transections.type = 1 THEN transections.amount ELSE - transections.amount END) as balance"),
                    DB::raw("DATE_FORMAT(transections.transaction_date, '%b') as month"),
                    DB::raw("YEAR(transections.transaction_date) as year")
                )
                ->whereYear('transections.transaction_date', $year) // Current year filter
                ->when($group, function ($query, $group) {
                    return $query->where('groups.id', $group); // Apply group filter only if group is provided
                })
                ->groupBy('members.id', 'groups.id', 'month', 'year')
                ->orderBy('groups.id')
                ->get();

            // Fetch previous year's total balance
            $previousYearBalances = DB::table('transections')
                ->join('members', 'transections.member_id', '=', 'members.id')
                ->select(
                    'members.id as member_id',
                    DB::raw("SUM(CASE WHEN transections.type = 1 THEN transections.amount ELSE - transections.amount END) as total_balance")
                )
                ->whereYear('transections.transaction_date', $year - 1) // Previous year filter
                ->groupBy('members.id')
                ->pluck('total_balance', 'member_id'); // Key-value pair of member_id => total_balance

            foreach ($data as $row) {
                $groupId = $row->group_id;
                $memberId = $row->member_id;
                $memberName = $row->member_name;

                if (!isset($report[$groupId])) {
                    $report[$groupId] = [
                        'group_name' => $row->group_name,
                        'members' => [],
                        'group_total' => 0,
                    ];
                }

                if (!isset($report[$groupId]['members'][$memberName])) {
                    $report[$groupId]['members'][$memberName] = [
                        'spouse_name' => $row->spouse_name,
                        'total_deposit' => 0,
                        'total_withdraw' => 0,
                        'balance' => 0,
                        'previous_year_balance' => $previousYearBalances[$memberId] ?? 0, // Add previous year balance
                        'months' => []
                    ];
                }

                $report[$groupId]['members'][$memberName]['months'][$row->month]['deposit'] = $row->total_deposit;
                $report[$groupId]['members'][$memberName]['months'][$row->month]['withdraw'] = $row->total_withdraw;

                $report[$groupId]['members'][$memberName]['total_deposit'] += $row->total_deposit + ($previousYearBalances[$memberId] ?? 0);
                $report[$groupId]['members'][$memberName]['total_withdraw'] += $row->total_withdraw;

                $report[$groupId]['members'][$memberName]['balance'] = ($report[$groupId]['members'][$memberName]['total_deposit'] - $report[$groupId]['members'][$memberName]['total_withdraw']);

                $report[$groupId]['group_total'] += $row->balance + ($previousYearBalances[$memberId] ?? 0);
            }
        }

        return view('report.savingsReport', compact('report', 'year'));
    }


}
