@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Permohonan Keanggotaan</h5>
                    <div class="card-datatable text-nowrap" id="both-scrollbars-example" style="height: 500px">
                        <table class="table">
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
                                    <th>KK</th>
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
                                    <td>
                                        <img src="{{ asset('storage/' . $pengajuan->ktp) }}" alt="KTP" width="50"
                                            data-bs-toggle="modal" data-bs-target="#modals-transparent" data-image="{{ asset('storage/' . $pengajuan->ktp) }}">
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $pengajuan->kartu_keluarga) }}" alt="Kartu Keluarga" width="50" 
                                            data-bs-toggle="modal" data-bs-target="#modals-transparent" data-image="{{ asset('storage/' . $pengajuan->kartu_keluarga) }}">
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $pengajuan->status_pk }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <form method="post"
                                                action="{{ route('verifikasi-pendaftaran.verifikasi', $pengajuan->id) }}"
                                                class="me-1">
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

                                <!-- Modal transparan -->
                                <div class="modal modal-transparent fade" id="modals-transparent" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img id="modalImage" src="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var successMessage = @json(session('status'));

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modals-transparent');
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute('data-image');
                var modalImage = document.getElementById('modalImage');
                modalImage.src = imageUrl;
            });
        });
    </script>
@endsection
