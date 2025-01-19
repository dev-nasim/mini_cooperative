<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SavingsAccount;
use Illuminate\Http\Request;

class SavingAccountController extends Controller
{
    public function index()
    {
        $data = SavingsAccount::leftJoin('members', 'savings_accounts.member_id', '=', 'members.id')
            ->selectRaw("savings_accounts.*,members.name as member_name,members.m_code as member_code")
            ->get();
        return view('savingAccounts.index',compact('data'));
    }

    public function create()
    {
        $member = Member::all();
        return view('savingAccounts.create',compact('member'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'member_id' => 'required',
                'saving_code' => 'required'
            ]);
            $data = new SavingsAccount();
            $data->member_id = $validatedData['member_id'];
            $data->saving_code = $validatedData['saving_code'];
            $data->status = 1;
            $data->save();
            return redirect()->route('saving_accounts.index')->with('success', 'Member Added successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = SavingsAccount::findOrFail($id);
        $member = Member::get();
        return view('savingAccounts.create', compact('data', 'member'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'member_id' => 'required',
                'saving_code' => 'required'
            ]);

            $data = SavingsAccount::findOrFail($id);
            $data->member_id = $validatedData['member_id'];
            $data->saving_code = $validatedData['saving_code'];
            $data->status = 1;
            $data->save();
            return redirect()->route('saving_accounts.index')->with('success', 'Account updated successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = SavingsAccount::find($id);
            $data->delete();
            return redirect()->route('saving_accounts.index')->with('success', 'Account successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('saving_accounts.index')->with('error', $exception->getMessage());
        }
    }

    public function getMemberDetails($memberId)
    {
        $member = Member::find($memberId);
        if ($member) {
            $lastSavingAccount = SavingsAccount::where('member_id', $member->id)->latest()->first();
            $nextSerial = $lastSavingAccount ? $lastSavingAccount->serial + 1 : 1;
            $formattedSerial = str_pad($nextSerial, 3, '0', STR_PAD_LEFT);
            return response()->json([
                'm_code' => $member->m_code,
                'saving_serial' => $formattedSerial,
            ]);
        }

        return response()->json(['error' => 'Member not found'], 404);
    }


}
