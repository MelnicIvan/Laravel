<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['category', 'tags'])->get();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function home()
    {
        $lastTask = Task::latest()->first();
        return view('home', compact('lastTask'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('tasks.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);
        $task = Task::create($validated);
        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }
        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
    }

    public function edit($id)
    {
        $task = Task::with('tags')->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Задача успешно обновлена!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }

    public function show($id)
    {
        $task = Task::with(['category', 'tags'])->findOrFail($id);
        return view('tasks.show', ['task' => $task]);
    }
}
