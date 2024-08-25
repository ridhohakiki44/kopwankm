@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Card Border Shadow -->
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
        <!--/ Card Border Shadow -->

    </div>
@endsection
