<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request){

        $title = "Halaman Tugas";


        return view('tasks.index', [
            'title' => $title,

        ]);
    }

    public function create(){

        $title = 'Halaman Tambah Tugas';

        return view('tasks.create', [
            'title'=> $title
        ]);
    }

    public function show(Task $task){
        $title = 'Halaman Detail Tugas';

        return view('tasks.show', [
            'title' => $title,
            'task' => $task
        ]);
    }

    public function edit(Task $task){
        $title = 'Halaman Edit Tugas';
        
        return view('tasks.edit', [
            'title' => $title,
            'task' => $task
        ]);
    }

    public function store(Request $request){
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'size:4', 'unique:tasks,code,']   
        ]);

        Task::create($validatedRequest);

        return redirect()->route('tasks.index')
            ->with('Succes', 'Tugas Berhasil Ditambahkan');
    }

    public function update(Request $request , Task $task){
        $validatedRequest = $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string',  'size:4', 'unique:tasks,code,' . $task->id],
        ]);

        $task->update($validatedRequest);

        return redirect()->route('tasks.index')
            ->with('Succes', 'Tugas Berhasil diubah');
    }

    public function destroy(Task $task){
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('Succes', 'Tugas Berhasil diubah');
    }
}
