<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Module;

use Auth;


class GroupsController extends Controller
{
    public function index()
    {
        $listGroups = Group::all();
        return view('admin.groups.lists', compact('listGroups'));
    }

    public function add()
    {
        return view('admin.groups.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required | unique:groups,name',
            ],
            [
                'name.required' => 'Name not empty',
                'email.unique' => 'Name already used',
            ]
        );

        $group = new Group();
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();

        return redirect()->route('admin.groups.index')->with('msg', 'Group is added');
    }

    public function edit(Group $group)
    {
        $this->authorize('update', $group);

        return view('admin.groups.edit', compact('group'));
    }

    public function postEdit(Group $group, Request $request)
    {
        $this->authorize('update', $group);
        $request->validate(
            [
                'name' => 'required | unique:groups,name,' . $group->id,
            ],
            [
                'name.required' => 'Name not empty',
                'name.unique' => 'Name already used',
            ]
        );

        $group->name = $request->name;
        $group->save();

        return back()->with('msg', 'Group is updated');
    }

    public function delete(Group $group)
    {
        $this->authorize('delete', $group);
        $userCount = $group->user->count();

        if ($userCount == 0) {
            Group::destroy($group->id);
            return redirect()->route('admin.groups.index')->with('msg', 'Group is deleted');
        }
        return redirect()->route('admin.groups.index')->with('msg', 'You cant not delete this group becase has' . $userCount . 'users are ussing this group');
    }

    public function permission(Group $group)
    {
        $this->authorize('permission', $group);

        $modules = Module::all();
        $roleArr = [];
        $roleJson = $group->permissions;
        if (!empty($group->permissions)) {
            $roleArr = json_decode($roleJson, true);
        }

        return view('admin.groups.permission', compact('group', 'modules', 'roleArr'));
    }

    public function postPermission(Group $group, Request $request)
    {
        $this->authorize('permission', $group);

        $roles = [];

        if (!empty($request->role)) {
            $roles = $request->role;
        }

        $roleJson = json_encode($roles);

        $group->permissions = $roleJson;

        $group->save();

        return back()->with('msg', 'Phan quyen thanh cong');
    }
}
