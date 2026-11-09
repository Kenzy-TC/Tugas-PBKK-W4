@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div><h1 class="mb-1">Data Mahasiswa</h1><p class="text-muted mb-0">Cari dan kelola data akademik.</p></div>
        @can('mahasiswa.create')
            <a href="{{ route('students.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Mahasiswa</a>
        @endcan
    </div>
@stop

@section('content')
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if ($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('students.index') }}" method="GET" class="form-inline">
                <label for="search" class="sr-only">Cari mahasiswa</label>
                <input id="search" type="search" name="search" value="{{ request('search') }}" class="form-control mr-2" placeholder="Cari NIM, nama, prodi, email...">
                <select name="status" class="form-control mr-2" aria-label="Filter status">
                    <option value="">Semua status</option>
                    @foreach (['Aktif', 'Cuti', 'Lulus'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search mr-1"></i> Cari</button>
                @if (request()->filled('search')) <a href="{{ route('students.index') }}" class="btn btn-link">Reset</a> @endif
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Email</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->nim }}</td><td>{{ $student->name }}</td><td>{{ $student->study_program }}</td><td>{{ $student->email }}</td>
                            <td><span class="badge badge-{{ $student->status === 'Aktif' ? 'success' : ($student->status === 'Cuti' ? 'warning' : 'secondary') }}">{{ $student->status }}</span></td>
                            <td class="text-right text-nowrap">
                                @can('mahasiswa.edit')
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary" aria-label="Edit {{ $student->name }}"><i class="fas fa-edit"></i></a>
                                @endcan
                                @role('Admin')
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data {{ addslashes($student->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" aria-label="Hapus {{ $student->name }}"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endrole
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data yang cocok dengan pencarian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">{{ $students->links('pagination::bootstrap-4') }}</div>
    </div>
@stop
