<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupUser;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        $user = auth()->user();
        $search = $request->search;
        if($user->user_type == 'client-user' || $user->user_type == 'client'){
            if($search != ''){
                $groups = Group::with('twoLatestUsers')->where('company_id', $user->company_id)->where('name', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(24);
                return response()->json([
                    'groups' => $groups
                ], 200);
            } else {
            $groups = Group::with('twoLatestUsers')->where('company_id', $user->company_id)->orderBy('id', 'desc')->paginate(24);
            return response()->json([
                'groups' => $groups
            ], 200);
        }
        } else{
            if($search != ''){
                $groups = Group::with('twoLatestUsers')->where('company_id', 0)->where('name', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(24);
                return response()->json([
                    'groups' => $groups
                ], 200);
            } else {
        $groups = Group::with('twoLatestUsers.user','twoLatestUsers.user')->where('company_id',0)->orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'groups' => $groups
        ], 200);
    }
    }
    }
    public function addGroup(Request $request)
    {
        $user = auth()->user();
        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->state = $request->state;
        $group->bank_name = $request->bank_name;
        $group->account_no = $request->account_no;
        $group->iban = $request->iban;
        $group->contact_person = $request->contact_person;
        $group->assigned_to = $request->assigned_to;
        $group->notes = $request->notes;
        if($user->user_type == 'client-user' || $user->user_type == 'client'){
            $group->company_id = $user->company_id;
        }
        $group->save();
        return response()->json([
            'message' => 'Successfully created group!'
        ], 201);
    }
    public function editGroup(Request $request)
    {
        $group = Group::find($request->id);
        $group->name = $request->name;
        $group->description = $request->description;
        $group->state = $request->state;
        $group->bank_name = $request->bank_name;
        $group->account_no = $request->account_no;
        $group->iban = $request->iban;
        $group->contact_person = $request->contact_person;
        $group->assigned_to = $request->assigned_to;
        $group->notes = $request->notes;
        $group->save();
        return response()->json([
            'message' => 'Successfully updated group!'
        ], 200);
    }
    public function deleteGroup($id)
    {
        $group = Group::find($id);
        $group->delete();
        return response()->json([
            'message' => 'Successfully deleted group!'
        ], 200);
    }
    public function getGroup($id)
    {
        $group = Group::find($id);
        return response()->json([
            'group' => $group
        ], 200);
    }
    public function getGroupUsers($id)
    {
        $group_users = GroupUser::with('user')->where('group_id', $id)->get();
        return response()->json([
            'group_users' => $group_users
        ], 200);
    }
    public function addGroupUsers(Request $request)
    {
        $group_id = $request->group_id;
        //delete previous users
        $group_users = GroupUser::where('group_id', $group_id)->get();
        foreach ($group_users as $group_user) {
            $group_user->delete();
        }
        $user_ids = $request->users_ids;
        foreach ($user_ids as $user_id) {
            $group_user = new GroupUser();
            $group_user->group_id = $group_id;
            $group_user->user_id = $user_id;
            $group_user->save();
        }
        return response()->json([
            'message' => 'Successfully added user to group!'
        ], 201);
    }
    public function deleteGroupUser($id)
    {
        $group_user = GroupUser::find($id);
        $group_user->delete();
        return response()->json([
            'message' => 'Successfully deleted user from group!'
        ], 200);
    }
}