@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Permohonan Keanggotaan</h5>
                    <div class="card-datatable text-nowrap" style="overflow-x: auto; overflow-y: auto; height: 300px;">
                        <table class="dt-scrollableTable table" style="width: 100%; white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>NIK</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telepon</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Pekerjaan</th>
                                    <th>Penghasilan</th>
                                    <th>KTP</th>
                                    <th>Kartu Keluarga</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($pengajuans as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->name }}</td>
                                    <td>{{ $pengajuan->email }}</td>
                                    <td>{{ $pengajuan->nik }}</td>
                                    <td>{{ $pengajuan->alamat }}</td>
                                    <td>{{ $pengajuan->nomor_telepon }}</td>
                                    <td>{{ $pengajuan->tanggal_lahir }}</td>
                                    <td>{{ $pengajuan->pekerjaan }}</td>
                                    <td>{{ $pengajuan->penghasilan }}</td>
                                    <td>{{ $pengajuan->ktp }}</td>
                                    <td>{{ $pengajuan->kartu_keluarga }}</td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $pengajuan->status_pk }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <form method="post"
                                                action="{{ route('verifikasi-pendaftaran.verifikasi', $pengajuan->id) }}" class="me-1">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-sm btn-success">Verifikasi</button>
                                            </form>
                                            <form method="post"
                                                action="{{ route('verifikasi-pendaftaran.tolak', $pengajuan->id) }}">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var successMessage = @json(session('status'));
    </script>
@endsection
