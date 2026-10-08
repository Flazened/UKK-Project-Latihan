<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $title = 'Halaman Tugas';
        $tasks = Task::select('id', 'title', 'department_id', 'area_id', 'due_at', 'asigner')->get();

        return view('tasks.index', [
            'title' => $title,
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        $title = 'Halaman Tambah Tugas';
        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('tasks.create', [
            'title' => $title,
            'departments' => $departments,
            'areas' => $areas
        ]);
    }

    public function show(Task $task)
    {
        $title = 'Halaman Detail Tugas';
        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('tasks.show', [
            'title' => $title,
            'task' => $task,
            'departments' => $departments,
            'areas' => $areas
        ]);
    }

    public function edit(Task $task)
    {
        $title = 'Halaman Edit Tugas';
        $departments = Department::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('tasks.edit', [
            'title' => $title,
            'task' => $task,
            'departments' => $departments,
            'areas' => $areas
        ]);
    }

    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'title' => ['required', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'asigner' => ['required', 'string'],
            'due_at' => ['required', 'date', 'after_or_equal:today']
        ]);

        Task::create($validatedRequest);

        return redirect()->route('tasks.index')
            ->with('success', '');
    }

    public function update(Request $request, Task $task) {
        $validatedRequest = $request->validate([
            'title' => ['required', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'asigner' => ['required', 'string'],
            'due_at' => ['required', 'date']
        ]);

        $task->update($validatedRequest);

        return redirect()->route('tasks.index')
            ->with('Succes', 'Data Tugas Berhasil diperbaruhi');
    }
        
    public function destroy(Task $task) {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('Succes', 'Tugas telah dihapus');
    }
}
