<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function getGroups()
    {
        $user = auth()->user();
        if($user->user_type == 'client-user' || $user->user_type == 'client'){
            $groups = Group::where('company_id', $user->company_id)->orderBy('id', 'desc')->paginate(24);
            return response()->json([
                'groups' => $groups
            ], 200);
        } else{
        $groups = Group::where('company_id',0)->orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'groups' => $groups
        ], 200);
    }
    }
    public function addGroup(Request $request)
    {
        $user = auth()->user();
        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
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
}
