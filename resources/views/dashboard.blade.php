@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">Dashboard Akademik</h1>
            <p class="text-muted mb-0">Ringkasan data portal akademik ITS.</p>
        </div>
        <span class="badge badge-primary p-2">{{ auth()->user()->getRoleNames()->first() }}</span>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner"><h3>{{ number_format($totalStudents) }}</h3><p>Total Mahasiswa</p></div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                <a href="{{ route('students.index') }}" class="small-box-footer">Lihat data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner"><h3>{{ number_format($activeStudents) }}</h3><p>Mahasiswa Aktif</p></div>
                <div class="icon"><i class="fas fa-user-check"></i></div>
                <a href="{{ route('students.index', ['status' => 'Aktif']) }}" class="small-box-footer">Status aktif <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner"><h3>{{ number_format($totalPrograms) }}</h3><p>Program Studi</p></div>
                <div class="icon"><i class="fas fa-university"></i></div>
                <a href="{{ route('students.index') }}" class="small-box-footer">Lihat mahasiswa <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple">
                <div class="inner"><h3>{{ number_format($totalUsers) }}</h3><p>Akun Pengguna</p></div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <span class="small-box-footer">Admin dan staf terdaftar</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title"><i class="fas fa-clock mr-1"></i> Mahasiswa Terbaru</h3>
            <div class="card-tools"><a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary">Semua data</a></div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($recentStudents as $student)
                        <tr>
                            <td>{{ $student->nim }}</td><td>{{ $student->name }}</td>
                            <td>{{ $student->study_program }}</td>
                            <td><span class="badge badge-{{ $student->status === 'Aktif' ? 'success' : ($student->status === 'Cuti' ? 'warning' : 'secondary') }}">{{ $student->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data mahasiswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
