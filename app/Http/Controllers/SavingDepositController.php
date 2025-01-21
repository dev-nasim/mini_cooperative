<?php

namespace App\Http\Controllers;

use App\Models\SavingsAccount;
use App\Models\Transection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SavingDepositController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = Transection::where('type', 1)
            ->leftJoin('members', 'transections.member_id', '=', 'members.id')
            ->leftJoin('groups', 'transections.group_id', '=', 'groups.id')
            ->leftJoin('cooperatives', 'transections.coop_id', '=', 'cooperatives.id')
            ->leftJoin('savings_accounts', 'transections.s_account_id', '=', 'savings_accounts.id')
            ->select('transections.*', 'members.name as member_name', 'members.m_code', 'groups.name as group_name', 'cooperatives.name as cooperative_name', 'savings_accounts.saving_code')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('members.name', 'LIKE', "%{$search}%")
                        ->orWhere('members.m_code', 'LIKE', "%{$search}%")
                        ->orWhere('savings_accounts.saving_code', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id','desc')
            ->get();
        return view('deposit.index', compact('data'));
    }


    public function create()
    {
        $accounts = SavingsAccount::where('savings_accounts.status', 1)
            ->leftJoin('members', 'savings_accounts.member_id', '=', 'members.id')
            ->select('savings_accounts.*', 'members.name as member_name')
            ->get();
        return view('deposit.create',compact('accounts'));
    }

    public function store(Request $request)
    {
        $savingAccount = SavingsAccount::where('savings_accounts.id', $request->s_account_id)
            ->leftJoin('members', 'savings_accounts.member_id', '=', 'members.id')
            ->select('savings_accounts.*', 'members.name', 'members.group_id', 'members.coop_id')
            ->first();
        try {
            $validatedData = $request->validate([
                's_account_id' => 'required',
                'amount' => 'required',
                'deposit_date' => 'required',
            ]);
            $data = new Transection();
            $data->s_account_id = $validatedData['s_account_id'];
            $data->deposit_date = $validatedData['deposit_date'];
            $data->amount = $validatedData['amount'];
            $data->coop_id = $savingAccount->coop_id;
            $data->member_id = $savingAccount->member_id;
            $data->group_id = $savingAccount->group_id;
            $data->type = 1;
            $data->save();
            return redirect()->route('deposit.index')->with('success', 'Data successfully inserted!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        try {
            $data = Transection::find($id);
            $data->delete();
            return redirect()->route('deposit.index')->with('success', 'Data successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('group.index')->with('error', $exception->getMessage());
        }
    }
    public function getTransactions($savingsAccountId)
    {
        $accountOpening = SavingsAccount::where('id', $savingsAccountId)->first();
        $deposit = Transection::where('s_account_id', $savingsAccountId)->where('type', 1)->sum('amount');
        $withdraw = Transection::where('s_account_id', $savingsAccountId)->where('type', 2)->sum('amount');
        $balance = $deposit - $withdraw;
        $transactions = [
            'total_deposit' => $deposit,
            'total_withdraw' => $withdraw,
            'balance' => $balance,
            'opening_date' => $accountOpening->created_at ? Carbon::parse($accountOpening->created_at)->format('d M Y') : null
        ];
        return response()->json($transactions);
    }

}
