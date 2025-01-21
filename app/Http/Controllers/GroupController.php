<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = Group::with('cooperative:id,name')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->orderBy('id','desc')->get();

        return view('group.index', compact('data'));
    }


    public function create()
    {
        $cooperative = Cooperative::get();
        return view('group.create',compact('cooperative'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'coop_id' => 'required',
                'code' => 'required|unique:groups,code',
            ]);
            $group = new Group();
            $group->name = $validatedData['name'];
            $group->coop_id = $validatedData['coop_id'];
            $group->code = $validatedData['code'];
            $group->status = 1;
            $group->save();
            return redirect()->route('group.index')->with('success', 'Data successfully inserted!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $cooperative = Cooperative::all();
        $data = Group::findOrFail($id);
        return view('group.create', compact('cooperative', 'data'));
    }


    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'coop_id' => 'required',
                'code' => 'required|unique:groups,code,' . $id . ',id',
            ]);
            $group = Group::findOrFail($id);
            $group->name = $validatedData['name'];
            $group->coop_id = $validatedData['coop_id'];
            $group->code = $validatedData['code'];
            $group->save();
            return redirect()->route('group.index')->with('success', 'Data successfully updated!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Group::find($id);
            $data->delete();
            return redirect()->route('group.index')->with('success', 'Data successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('group.index')->with('error', $exception->getMessage());
        }
    }
}
