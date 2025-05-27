<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $query = $project->tasks();

        if ($search = request('search')) {
            $query->where('title', 'like', "%$search%");
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('project', 'tasks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        // Pass the project to the view
        return view('tasks.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task = new Task($request->only('title', 'description', 'due_date'));
        $task->project_id = $project->id;
        $task->save();

        return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        // Validate the input
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
        ]);

        // Update the task
        $task->update($validated);

        // Redirect back with success message
        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Task deleted successfully!');
    }

    public function toggleStatus(Task $task)
    {
        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => "Toggled task status: {$task->title}"
        ]);

        return response()->json(['status' => $task->status]);
    }

}
