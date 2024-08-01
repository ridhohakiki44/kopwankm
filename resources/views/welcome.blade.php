@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if (auth()->user()->role == '')
                <div class="card-header">
                    <a href="{{ route('permohonan-keanggotaan.index') }}" class="btn btn-primary me-2">Ajukan</a>
                </div>
                @endif
                <div class="card-body">
                    @if (auth()->user()->role == 'calon_anggota')
                        <h5>Selamat datang, {{ auth()->user()->name }}! Anda telah berhasil mengajukan pendaftaran anggota. Saat ini pendaftaran anda sedang dalam proses verifikasi oleh pengelola koperasi.</h5>
                        <h5>Status Pendaftaran : Dalam Proses Verifikasi</h5>
                    @else
                        <h5>Selamat datang, {{ auth()->user()->name }}! Anda telah berhasil membuat akun. Untuk mendapatkan akses sebagai anggota koperasi, silakan lengkapi dan ajukan pendaftaran anggota.</h5>
                        <h5>Status Pendaftaran : Belum Mengajukan</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var successMessage = @json(session('status'));
</script>

@endsection
