<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\UserDetail;

class UserDetailController extends Controller
{
    public function index()
    {
        $userDetails = UserDetail::with('user:id,username,name')->get(); // Fetch user details with related user
        return response()->json($userDetails);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user_details,email',
        ]);

        $userDetail = UserDetail::create($request->all());
        return response()->json($userDetail, 201);
    }

    public function show($id)
    {
        $userDetail = UserDetail::findOrFail($id);
        return response()->json($userDetail);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:user_details,email,' . $id,
        ]);

        $userDetail = UserDetail::findOrFail($id);
        $userDetail->update($request->all());

        // Eager load
        $userDetail->load('user:id,username,name');

        return response()->json($userDetail, 200);
    }

    public function destroy($id)
    {
        $userDetail = UserDetail::findOrFail($id);
        $userDetail->delete();
        return response()->json(null, 204);
    }
}
