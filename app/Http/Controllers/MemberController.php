<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = Member::with('cooperative:id,name', 'group:id,name')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('m_phone', 'like', '%' . $search . '%')
                        ->orWhere('m_nid', 'like', '%' . $search . '%')
                        ->orWhere('m_code', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('member.index', compact('data'));
    }


    public function create()
    {
        $cooperative = Cooperative::get();
        $group = [];
        return view('member.create',compact('cooperative','group'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'm_phone' => 'required',
                'address' => 'required|string|max:500',
                'group_id' => 'required',
                'coop_id' => 'required'
            ]);
            $data = new Member();
            $data->name = $validatedData['name'];
            $data->m_phone = $validatedData['m_phone'];
            $data->address = $validatedData['address'];
            $data->group_id = $validatedData['group_id'];
            $data->coop_id = $validatedData['coop_id'];
            $data->m_code = $request->m_code;
            $data->m_nid = $request->m_nid;
            $data->spouse_relation = $request->spouse_relation;
            $data->spouse_name = $request->spouse_name;
            $data->gender = $request->gender;
            $data->status = 1;
            $data->save();
            return redirect()->route('member.index')->with('success', 'Member Added successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $data = Member::findOrFail($id);
        $cooperative = Cooperative::get();
        $group = Group::where('coop_id', $data->coop_id)->get();
        return view('member.create', compact('data', 'cooperative', 'group'));
    }


    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'm_phone' => 'required',
                'address' => 'required|string|max:500',
                'group_id' => 'required',
                'coop_id' => 'required'
            ]);

            $data = Member::findOrFail($id);
            $data->name = $validatedData['name'];
            $data->m_phone = $validatedData['m_phone'];
            $data->address = $validatedData['address'];
            $data->group_id = $validatedData['group_id'];
            $data->coop_id = $validatedData['coop_id'];
            $data->m_code = $request->m_code;
            $data->m_nid = $request->m_nid;
            $data->spouse_relation = $request->spouse_relation;
            $data->spouse_name = $request->spouse_name;
            $data->gender = $request->gender;
            $data->status = 1;
            $data->save();
            return redirect()->route('member.index')->with('success', 'Member updated successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Member::find($id);
            $data->delete();
            return redirect()->route('user.index')->with('success', 'Member successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('user.index')->with('error', $exception->getMessage());
        }
    }

    public function getGroupsByCooperative(Request $request)
    {
        $coop_id = $request->coop_id;
        $groups = Group::where('coop_id', $coop_id)->get();
        return response()->json($groups);
    }

    public function getGroupDetails(Request $request)
    {
        $group = Group::find($request->group_id);
        if ($group) {
            $lastMember = Member::where('group_id', $group->id)->latest()->first();
            $serial = $lastMember ? $lastMember->m_code : 0;
            $nextSerial = (int) substr($serial, strpos($serial, '-') + 1) + 1;
            $formattedSerial = str_pad($nextSerial, 3, '0', STR_PAD_LEFT);
            return response()->json([
                'group_code' => $group->code,
                'next_serial' => $formattedSerial
            ]);
        }
        return response()->json(['error' => 'Group not found'], 404);
    }



}
