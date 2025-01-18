<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::get();
        return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone' => 'required',
                'password' => 'nullable|min:5',
                'address' => 'required|string|max:500',
            ]);
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];
            $user->password = Hash::make($validatedData['password']);
            $user->address = $validatedData['address'];
            $user->status = 1;
            $user->save();
            return redirect()->route('user.index')->with('success', 'User created successfully!');
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
        $user = User::findOrFail($id);
        return view('user.create', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id . '|max:255',
                'phone' => 'required',
                'password' => 'nullable|min:5',
                'address' => 'required|string|max:500',
            ]);

            $user = User::findOrFail($id);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];

            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->address = $validatedData['address'];
            $user->save();
            return redirect()->route('user.index')->with('success', 'User updated successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred: ' . $exception->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = User::find($id);
            $data->delete();
            return redirect()->route('user.index')->with('success', 'Data successfully deleted!');
        }catch (\Exception $exception){
            return redirect()->route('user.index')->with('error', $exception->getMessage());
        }
    }

}
