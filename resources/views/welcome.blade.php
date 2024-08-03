@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if (auth()->user()->status_pk == '' || auth()->user()->status_pk == 'ditolak')
                <div class="card-header">
                    <a href="{{ route('pendaftaran-anggota.showForm') }}" class="btn btn-primary me-2">
                        @if (auth()->user()->status_pk == 'ditolak')
                            Ajukan Kembali
                        @else
                            Ajukan
                        @endif
                    </a>
                </div>
                @endif
                <div class="card-body">
                    @if (auth()->user()->status_pk == 'mengajukan')
                        <h5>Selamat, {{ auth()->user()->name }}! Anda telah berhasil mengajukan pendaftaran anggota. Saat ini pendaftaran anda sedang dalam proses verifikasi oleh pengelola koperasi.</h5>
                        <h5>Status Pendaftaran : Dalam Proses Verifikasi</h5>
                    @elseif (auth()->user()->status_pk == 'ditolak')
                        <h5>Mohon maaf, {{ auth()->user()->name }}! Untuk saat ini koperasi sedang tidak menerima anggota. Anda bisa mencoba mengajukan lagi lain kali.</h5>
                        <h5>Status Pendaftaran : Ditolak</h5>
                    @else
                        <h5>Selamat datang, {{ auth()->user()->name }}! Anda telah berhasil membuat akun. Untuk mendapatkan akses sebagai anggota koperasi, silakan ajukan pendaftaran anggota.</h5>
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
