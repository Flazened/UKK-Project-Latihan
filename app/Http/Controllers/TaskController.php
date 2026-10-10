<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Submission;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
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
        $users = User::orderBy('role')->get();

        return view('tasks.create', [
            'title' => $title,
            'departments' => $departments,
            'areas' => $areas,
            'users' => $users
        ]);
    }

    public function collect(Task $task)
    {
        $title = 'Halaman Kumpul Tugas';

        $dealer = auth()->user()->dealer;

        $submission = Submission::where('task_id', $task->id)
            ->where('dealer_id', $dealer->id)
            ->first();

        // Cek boleh submit atau enggak
        $deadlineLewat = now()->greaterThan(\Carbon\Carbon::parse($task->due_at)->endOfDay());
        $statusFinal = $submission && in_array($submission->status, ['DISETUJUI', 'DITOLAK']);
        $logs = $submission
            ? $submission->logs()->paginate(5)
            : collect();   // collection kosong kalau belum submit
        $bolehSubmit = ! $deadlineLewat && ! $statusFinal;

        return view('tasks.collect', [
            'title'       => $title,
            'task' => $task,
            'logs' => $logs,
            'submission'  => $submission,
            'bolehSubmit' => $bolehSubmit,
            'deadlineLewat' => $deadlineLewat,
            'statusFinal' => $statusFinal,
        ]);
    }

    public function manage(Task $task)
    {
        $title = 'Halaman Kelola Tugas';

        $submissions = Submission::with('dealer')
            ->where('task_id', $task->id)
            ->latest('submitted_at')
            ->get();

        return view('tasks.manage', [
            'title'       => $title,
            'task'        => $task,
            'submissions' => $submissions,
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

    public function update(Request $request, Task $task)
    {
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

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('Succes', 'Tugas telah dihapus');
    }



    public function storeCollect(Request $request, Task $task)
    {
        // 1. Validasi
        $validated = $request->validate([
            'link_drive' => ['required', 'string', 'max:255'],
            'note'       => ['nullable', 'string'],
        ]);

        // 2. Cek deadline
        if (now()->greaterThan(Carbon::parse($task->due_at)->endOfDay())) {
            return back()->with('error', 'Deadline sudah lewat.');
        }

        // 3. Cek submission lama
        $submission = Submission::where('task_id', $task->id)
            ->where('dealer_id', auth()->user()->dealer->id)
            ->first();

        // 4. Kalau ada & statusnya final → tolak
        if ($submission && in_array($submission->status, ['DISETUJUI', 'DITOLAK'])) {
            return back()->with('error', 'Tugas sudah final.');
        }

        // 5. Update atau create
        if ($submission) {
            $submission->update([
                'link_drive'      => $validated['link_drive'],
                'note'            => $validated['note'] ?? null,
                'submitted_at'    => now(),
                'supervisor_note' => null,
            ]);
            $activity = 'PENGUMPULAN_ULANG';
        } else {
            $submission = Submission::create([
                'task_id'      => $task->id,
                'dealer_id'    => auth()->user()->dealer->id,
                'link_drive'   => $validated['link_drive'],
                'note'         => $validated['note'] ?? null,
                'submitted_at' => now(),
            ]);
            $activity = 'KUMPUL';
        }

        // 6. Log
        $submission->logs()->create([
            'activity' => $activity,
            'note'     => $validated['note'] ?? null,
        ]);

        // 7. Redirect
        return redirect()->route('tasks.collect', $task->id)
            ->with('success', 'Tugas berhasil dikumpulkan.');
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

    public function reviewSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'status'  => ['required', 'in:DISETUJUI,REVISI,DITOLAK'],
            'catatan' => ['nullable', 'string'],
        ]);

        $submission->update([
            'status'          => $validated['status'],
            'supervisor_note' => $validated['catatan'] ?? null,
        ]);

        // Log REVIEW
        $submission->logs()->create([
            'activity' => 'REVIEW',
            'note'     => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('tasks.manage', $submission->task_id)
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
