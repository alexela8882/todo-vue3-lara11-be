<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\TodoStatus as Status;

class TodoStatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();
        return response()->json($statuses, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::create($request->only('name'));

        return response()->json($status, 201);
    }

    public function show($id)
    {
        $status = Status::find($id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        return response()->json($status, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::find($id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $status->update($request->only('name'));

        return response()->json($status, 200);
    }

    public function destroy($id)
    {
        $status = Status::find($id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $status->delete();

        return response()->json(['message' => 'Status deleted'], 204);
    }
}
