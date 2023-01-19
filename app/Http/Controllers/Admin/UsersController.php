<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;
use  App\Models\Group;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsersController extends Controller
{
    public function index()
    {
        $listUsers = User::all();
        return view('admin.users.lists', compact('listUsers'));
    }

    public function add()
    {
        $groups = Group::all();

        return view('admin.users.add', compact('groups'));
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required | email | unique:users,email',
                'password' => 'required',
                'group' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Please select select');
                    }
                }]
            ],
            [
                'name.required' => 'Name not empty',
                'email.required' => 'Email not empty',
                'email.email' => 'Email is not in the correct format',
                'email.unique' => 'Email already used',
                'password.required' => 'Pasword not empty',
                'group.required' => 'Please select group'
            ]
        );

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group;
        $user->user_id = Auth::user()->id;
        $user->save();

        return redirect()->route('admin.users.index')->with('msg', 'User is added');
    }

    public function edit(User $user)
    {
        $this->authorize('delete', $user);

        $groups = Group::all();
        return view('admin.users.edit', compact('groups', 'user'));
    }

    public function postEdit(User $user, Request $request)
    {
        $this->authorize('delete', $user);

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required | email | unique:users,email,' . $user->id,
                'group' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Please select select');
                    }
                }]
            ],
            [
                'name.required' => 'Name not empty',
                'email.required' => 'Email not empty',
                'email.email' => 'Email is not in the correct format',
                'email.unique' => 'Email already used',
                'group.required' => 'Please select group'
            ]
        );

        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        };
        $user->group_id = $request->group;
        $user->save();

        return back()->with('msg', 'User is updated');
    }


    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        if (Auth::user()->id !== $user->id) {
            User::destroy($user->id);
            return redirect()->route('admin.users.index')->with('msg', 'User is deleted');
        }
        return redirect()->route('admin.users.index')->with('msg', 'You cant delete this user');
    }
}
