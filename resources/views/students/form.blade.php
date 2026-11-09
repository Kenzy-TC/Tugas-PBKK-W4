@extends('adminlte::page')

@section('title', $student->exists ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')

@section('content_header')
    <h1>{{ $student->exists ? 'Edit Data Mahasiswa' : 'Tambah Mahasiswa' }}</h1>
@stop

@section('content')
    @if ($errors->any()) <div class="alert alert-danger">Periksa kembali isian yang ditandai.</div> @endif
    <div class="card card-primary card-outline">
        <form method="POST" action="{{ $student->exists ? route('students.update', $student) : route('students.store') }}">
            @csrf
            @if ($student->exists) @method('PUT') @endif
            <div class="card-body">
                @foreach (['nim' => 'NIM', 'name' => 'Nama lengkap', 'study_program' => 'Program studi', 'email' => 'Email'] as $field => $label)
                    <div class="form-group">
                        <label for="{{ $field }}">{{ $label }}</label>
                        <input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $student->$field) }}" class="form-control @error($field) is-invalid @enderror" @if ($field === 'email') type="email" @else type="text" @endif required>
                        @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                @endforeach
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                        @foreach (['Aktif', 'Cuti', 'Lulus'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $student->status ?: 'Aktif') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('students.index') }}" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@stop
