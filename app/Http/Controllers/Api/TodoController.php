<?php

// app/Http/Controllers/Api/TodoController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Todo;

class TodoController extends Controller
{

    // Get all todos
    public function all()
    {
        // Eager load statuses and group todos by status
        $todos = Todo::with('status')->get()->groupBy(function ($todo) {
            return $todo->status->name; // Group by the status name
        });

        // Format the response to include count per group
        $formattedResponse = $todos->map(function ($group, $status) {
            return [
                'id' => $group[0]->todo_status_id,
                'status' => $status,
                'count' => $group->count(), // Count of todos in this status
                'todos' => $group // List of todos in this status
            ];
        });

        return response()->json($formattedResponse, 200);
    }

    // Get all todos for the authenticated user
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())
            ->with(['status:id,name', 'user:id,name,username'])
            ->get();

        return response()->json($todos, 200);
    }

    // Create a new todo for the authenticated user
    public function store(Request $request)
    {
        $request->validate([
            'todo_status_id' => 'required|exists:todo_statuses,id',
            'todo' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Use the authenticated user's ID
        $todo = Todo::create([
            'user_id' => Auth::id(), // Set user_id to the authenticated user
            'todo_status_id' => $request->todo_status_id,
            'todo' => $request->todo,
            'description' => $request->description,
        ]);

        // Eager load
        $todo->load('status:id,name');

        return response()->json($todo, 201);
    }

    // Get a specific todo for the authenticated user
    public function show($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($todo);
    }

    // Update a todo for the authenticated user
    public function update(Request $request, $id)
    {
        $request->validate([
            'todo_status_id' => 'required|exists:todo_statuses,id',
            'todo' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $todo = Todo::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $todo->update($request->only(['todo_status_id', 'todo', 'description']));

        // Eager load
        $todo->load('status:id,name');

        return response()->json($todo);
    }

    // Delete a todo for the authenticated user
    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $todo->delete();

        return response()->json(null, 204);
    }
}
