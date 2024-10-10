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
    // Get all todos for the authenticated user
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())
            ->with(['status', 'user'])
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
