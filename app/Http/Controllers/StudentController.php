<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mahasiswa.view')->only('index');
        $this->middleware('permission:mahasiswa.create')->only(['create', 'store']);
        $this->middleware('permission:mahasiswa.edit')->only(['edit', 'update']);
        $this->middleware('role:Admin')->only('destroy');
    }

    public function index(Request $request): View
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:Aktif,Cuti,Lulus'],
        ]);

        $students = Student::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $keyword = $request->string('search')->trim()->toString();

                $query->where(function ($query) use ($keyword) {
                    $query->where('nim', 'like', "%{$keyword}%")
                        ->orWhere('name', 'like', "%{$keyword}%")
                        ->orWhere('study_program', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.form', ['student' => new Student()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Student::create($this->validatedData($request));

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        return view('students.form', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validatedData($request, $student));

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Student $student = null): array
    {
        $id = $student?->id;

        return $request->validate([
            'nim' => ['required', 'string', 'max:20', 'unique:students,nim,' . $id],
            'name' => ['required', 'string', 'max:255'],
            'study_program' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $id],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
        ]);
    }
}
