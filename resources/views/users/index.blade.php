@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Daftar Anggota</h5>
                <div class="card-body">

                    <!-- Input Pencarian -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="text" id="searchName" class="form-control" placeholder="Cari Nama">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" id="searchNik" class="form-control" placeholder="Cari NIK">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" id="searchAlamat" class="form-control" placeholder="Cari Alamat">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" id="searchPekerjaan" class="form-control" placeholder="Cari Pekerjaan">
                        </div>
                    </div>

                    <div class="table-responsive">
                        @if ($users->isEmpty())
                                <p>Tidak ada user.</p>
                        @else
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>NIK</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Pekerjaan</th>
                                        <th>Penghasilan</th>
                                        <th>KTP</th>
                                        <th>KK</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center user-name">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar me-2">
                                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/avatars/default-avatar.png') }}" alt="Avatar" class="rounded-circle" data-bs-toggle="modal" data-bs-target="#modals-avatar-{{ $loop->iteration }}">

                                                            <!-- Modal transparan -->
                                                            <div class="modal modal-transparent fade" id="modals-avatar-{{ $loop->iteration }}" tabindex="-1">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <img id="modalImage" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/avatars/default-avatar.png') }}" class="img-fluid">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <span class="emp_name text-truncate">{{ $user->name }}</span>
                                                        <small class="emp_post text-truncate text-muted">{{ $user->role }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->nik }}</td>
                                            <td>{{ $user->tanggal_lahir }}</td>
                                            <td>{{ $user->alamat }}</td>
                                            <td>{{ $user->nomor_telepon }}</td>
                                            <td>{{ $user->pekerjaan }}</td>
                                            <td>Rp{{ $user->penghasilan }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $user->ktp) }}" alt="KTP" width="50"
                                                    data-bs-toggle="modal" data-bs-target="#modals-transparent-ktp-{{ $loop->iteration }}">
    
                                                <!-- Modal transparan -->
                                                <div class="modal modal-transparent fade" id="modals-transparent-ktp-{{ $loop->iteration }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <img id="modalImage" src="{{ asset('storage/' . $user->ktp) }}" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/' . $user->kartu_keluarga) }}" alt="Kartu Keluarga" width="50" 
                                                    data-bs-toggle="modal" data-bs-target="#modals-transparent-kartu-keluarga-{{ $loop->iteration }}">
    
                                                <!-- Modal transparan -->
                                                <div class="modal modal-transparent fade" id="modals-transparent-kartu-keluarga-{{ $loop->iteration }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <img id="modalImage" src="{{ asset('storage/' . $user->kartu_keluarga) }}" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-success">
                                                    {{ $user->status_pk }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInputs = {
            name: document.getElementById('searchName'),
            nik: document.getElementById('searchNik'),
            alamat: document.getElementById('searchAlamat'),
            pekerjaan: document.getElementById('searchPekerjaan')
        };

        const userTableBody = document.getElementById('userTableBody');
        const users = userTableBody.getElementsByTagName('tr');

        Object.values(searchInputs).forEach(input => {
            input && input.addEventListener('input', function () {
                filterTable();
            });
        });

        function filterTable() {
            for (let i = 0; i < users.length; i++) {
                const userRow = users[i];
                let show = true;

                if (searchInputs.name && searchInputs.name.value && !userRow.children[1].textContent.toLowerCase().includes(searchInputs.name.value.toLowerCase())) {
                    show = false;
                }
                if (searchInputs.nik && searchInputs.nik.value && !userRow.children[3].textContent.toLowerCase().includes(searchInputs.nik.value.toLowerCase())) {
                    show = false;
                }
                if (searchInputs.alamat && searchInputs.alamat.value && !userRow.children[5].textContent.toLowerCase().includes(searchInputs.alamat.value.toLowerCase())) {
                    show = false;
                }
                if (searchInputs.pekerjaan && searchInputs.pekerjaan.value && !userRow.children[7].textContent.toLowerCase().includes(searchInputs.pekerjaan.value.toLowerCase())) {
                    show = false;
                }

                userRow.style.display = show ? '' : 'none';
            }
        }
    });
</script>

@endsection
