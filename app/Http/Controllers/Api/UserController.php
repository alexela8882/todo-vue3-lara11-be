<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['type:id,name'])
            ->where('id', '!=', \Auth::user()->id)
            ->get();
        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make('password'), // default
            'user_type_id' => $request->user_type_id ?? 2, // default: user
        ]);

        // Eager load the related user type
        $user->load('type:id,name');

        // store user details
        $userDetail = new UserDetail;
        $userDetail->user_id = $user->id;
        $userDetail->first_name = '';
        $userDetail->last_name = '';
        $userDetail->email = '';
        $userDetail->save();

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'password' => 'sometimes|string|min:8',
            'user_type_id' => 'sometimes|exists:user_types,id', // Validate user_type_id
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->user_type_id = $request->user_type_id;
        $user->password = bcrypt($request->password);
        $user->update();

        // Eager load the related user type
        $user->load('type:id,name');

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
