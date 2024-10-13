@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if (auth()->user()->status_pk == '' || auth()->user()->status_pk == 'ditolak')
                <div class="card-header">
                    <a href="{{ route('pendaftaran-anggota.showForm') }}" class="btn btn-success me-2">
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
                        <h5>Status Pendaftaran : <span class="badge bg-label-warning">Dalam Proses Verifikasi</span></h5>
                    @elseif (auth()->user()->status_pk == 'ditolak')
                        <h5>Mohon maaf, {{ auth()->user()->name }}! Untuk saat ini koperasi sedang tidak menerima anggota. Anda bisa mencoba mengajukan lagi lain kali.</h5>
                        <h5>Status Pendaftaran : <span class="badge bg-label-danger">Ditolak</span></h5>
                    @else
                        <h5>Selamat datang, {{ auth()->user()->name }}! Anda telah berhasil membuat akun. Untuk mendapatkan akses sebagai anggota koperasi, silakan ajukan pendaftaran anggota.</h5>
                        <h5>Status Pendaftaran : <span class="badge bg-label-primary">Belum Mengajukan</span></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Aturan Simpanan</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Simpanan wajib dilakukan setiap bulan sejumlah Rp20.000.</li>
                        <li>Simpanan wajib dibayar pada tanggal 1 setiap bulan, bagi yang telat membayar akan dikenakan denda Rp1.000 perhari.</li>
                        <li>Untuk peminjam dengan jumlah besar atau sama dengan Rp10.000.000, maka simpanan wajib Rp50.000.</li>
                        <li>Untuk peminjam dengan jumlah besar atau sama dengan Rp50.000.000, maka simpanan wajib Rp100.000.</li>
                        <li>Anggota juga dapat melakukan simpanan sukarela</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Aturan Pinjaman</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Pinjaman hanya diberikan kepada anggota aktif yang telah menyimpan minimal 2 tahun.</li>
                        <li>Suku bunga pinjaman sebesar 1% per bulan.</li>
                        <li>Jangka waktu pinjaman ditentukan oleh anggota ketika pengajuan.</li>
                        <li>Permohonan pinjaman harus disertai jaminan seperti sertifikat tanah, sertifikat rumah, BPKB, dan surat berharga lainnya.</li>
                        <li>Angsuran pinjaman yang telah melewati tanggal jatuh tempo akan dikenankan denda Rp1.000 perhari</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    var successMessage = @json(session('status'));
</script>

@endsection
