<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use Illuminate\Http\Request;

class CooperativeController extends Controller
{

    public function index()
    {
        $data = Cooperative::get();
        return view('cooperative.index', compact('data'));
    }

    public function create()
    {
        return view('cooperative.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required'
            ]);
            $user = new Cooperative();
            $user->name = $validatedData['name'];
            $user->code = $validatedData['code'];
            $user->contact = $request->contact;
            $user->contact_person = $request->contact_person;
            $user->status = 1;
            $user->save();
            return redirect()->route('cooperative.index')->with('success', 'Data successfully inserted!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }


    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        $data = Cooperative::findOrFail($id);
        return view('cooperative.create', compact('data'));
    }


    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required'
            ]);
            $user = Cooperative::findOrFail($id);
            $user->name = $validatedData['name'];
            $user->code = $validatedData['code'];
            $user->contact = $request->contact;
            $user->contact_person = $request->contact_person;
            $user->save();
            return redirect()->route('cooperative.index')->with('success', 'User updated successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }


    public function destroy(string $id)
    {
        try {
            $data = Cooperative::find($id);
            $data->delete();
            return redirect()->route('cooperative.index')->with('success', 'Data successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('cooperative.index')->with('error', $exception->getMessage());
        }
    }
}
