<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\SubmissionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function manage(Task $task)
    {
        $title  = 'Halaman Kirim Tugas';
        $dealer = Auth::user()->dealer;

        $submission = Submission::where('task_id', $task->id)
            ->where('dealer_id', $dealer->id)
            ->latest()
            ->first();

        return view('tasks.collect', [
            'title'      => $title,
            'task'       => $task,
            'submission' => $submission,
            'logs'       => $submission?->logs()->latest()->get() ?? collect(),
            'dealer'     => $dealer,
        ]);
    }

    // === DEALER: Submit tugas ===
    public function storeCollect(Request $request, Task $task)
    {
        $validated = $request->validate([
            'link_drive' => ['required', 'url'],
            'note'       => ['nullable', 'string'],
        ]);

        $dealer = Auth::user()->dealer;

        // Cek deadline
        if ($task->due_at && now()->startOfDay()->gt($task->due_at)) {
            return back()->withErrors(['link_drive' => 'Deadline sudah lewat.']);
        }

        $submission = Submission::where('task_id', $task->id)
            ->where('dealer_id', $dealer->id)
            ->latest()
            ->first();

        // 🚩 Flag: DISETUJUI / DITOLAK → gak bisa submit lagi
        if ($submission && ! $submission->canBeResubmitted()) {
            return back()->withErrors(['link_drive' => 'Tugas sudah final, tidak bisa dikumpulkan lagi.']);
        }

        DB::transaction(function () use ($task, $dealer, $validated, &$submission) {
            if ($submission) {
                // Pengumpulan ulang
                $submission->update([
                    'link_drive'      => $validated['link_drive'],
                    'note'            => $validated['note'] ?? null,
                    'status'          => 'REVISI', // reset flag
                    'supervisor_note' => null,
                    'submitted_at'    => now(),
                ]);

                SubmissionLog::create([
                    'submission_id' => $submission->id,
                    'activity'      => 'Pengumpulan Ulang',
                    'note'          => $validated['note'] ?? null,
                ]);
            } else {
                // Pengumpulan pertama
                $submission = Submission::create([
                    'task_id'      => $task->id,
                    'dealer_id'    => $dealer->id,
                    'link_drive'   => $validated['link_drive'],
                    'note'         => $validated['note'] ?? null,
                    'status'       => 'REVISI',
                    'submitted_at' => now(),
                ]);

                SubmissionLog::create([
                    'submission_id' => $submission->id,
                    'activity'      => 'Kumpul',
                    'note'          => $validated['note'] ?? null,
                ]);
            }
        });

        return redirect()->route('tasks.manage', $task->id)
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // === SUPERVISOR: Halaman pemeriksaan ===
    public function collect(Task $task)
    {
        $title       = 'Halaman Manage Tugas';
        $submissions = Submission::with(['dealer', 'logs'])
            ->where('task_id', $task->id)
            ->latest()
            ->get();

        return view('tasks.manage', [
            'title'       => $title,
            'task'        => $task,
            'submissions' => $submissions,
        ]);
    }

    // === SUPERVISOR: Review ===
    public function reviewSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'status'          => ['required', 'in:DISETUJUI,REVISI,DITOLAK'],
            'supervisor_note' => ['nullable', 'string'],
        ]);

        $activity = match ($validated['status']) {
            'DISETUJUI' => 'Supervisor Menyetujui Pengumpulan',
            'REVISI'    => 'Supervisor Minta Revisi',
            'DITOLAK'   => 'Supervisor Menolak Hasil Pekerjaan',
        };

        DB::transaction(function () use ($submission, $validated, $activity) {
            $submission->update([
                'status'          => $validated['status'],
                'supervisor_note' => $validated['supervisor_note'] ?? null,
            ]);

            SubmissionLog::create([
                'submission_id' => $submission->id,
                'activity'      => $activity,
                'note'          => $validated['supervisor_note'] ?? null,
            ]);
        });

        return back()->with('success', 'Status berhasil diperbarui.');
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
}
