@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @if (auth()->user()->role != 'anggota')
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="{{ route('verifikasi-pendaftaran') }}">
                    <div class="card card-border-shadow-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-user-up ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">{{ $permohonanKeanggotaanCount }}</h4>
                            </div>
                            <p class="mb-1">Pendaftaran Anggota</p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="{{ route('loans.verification.page') }}">
                    <div class="card card-border-shadow-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-warning"><i
                                            class="ti ti-file-isr ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">{{ $pengajuanPinjamanCount }}</h4>
                            </div>
                            <p class="mb-1">Pengajuan Pinjaman</p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="{{ route('loans.edit.page') }}">
                        <div class="card card-border-shadow-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2 pb-1">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-danger"><i
                                                class="ti ti-file-time ti-md"></i></span>
                                    </div>
                                    <h4 class="ms-1 mb-0">{{ $menungguPencairanDanaCount }}</h4>
                                </div>
                                <p class="mb-1">Menunggu Pencairan Dana</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="{{ route('users.index') }}">
                    <div class="card card-border-shadow-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-info"><i class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">{{ $anggotaCount }}</h4>
                            </div>
                            <p class="mb-1">Anggota</p>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        @endif
        
        <div class="row">
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
@endsection
