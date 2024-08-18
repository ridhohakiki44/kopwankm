@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Pengajuan Pinjaman</h5>
                <div class="card-body">
                    <div class="card-datatable text-nowrap" id="both-scrollbars-example" style="height: 500px">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Jangka Waktu (bulan)</th>
                                    <th>Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Jaminan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanLoans as $loan)
                                    <tr>
                                        <td>{{ $loan->user->name }}</td>
                                        <td>Rp{{ number_format($loan->jumlah, 2, ',', '.') }}</td>
                                        <td>{{ $loan->jangka_waktu }}</td>
                                        <td>{{ $loan->bank }}</td>
                                        <td>{{ $loan->no_rek }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $loan->jaminan) }}" alt="jaminan"
                                                width="50" data-bs-toggle="modal"
                                                data-bs-target="#modals-transparent-{{ $loop->iteration }}">

                                            <!-- Modal transparan -->
                                            <div class="modal modal-transparent fade" id="modals-transparent-{{ $loop->iteration }}"
                                                tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <img id="modalImage"
                                                                src="{{ asset('storage/' . $loan->jaminan) }}"
                                                                class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $loan->status }}</td>
                                        <td>{{ $loan->keterangan }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal">
                                                Verifikasi
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">

                                                        <form id="loanForm" method="POST">
                                                            @csrf
                                                            
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel1">Verifikasi Pengajuan Pinjaman
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col mb-3">
                                                                        <label for="keterangan"
                                                                            class="form-label">Keterangan</label>
                                                                        <input type="text" id="keterangan" name="keterangan"
                                                                            class="form-control" placeholder="Masukan keterangan" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button id="rejectBtn" type="button" class="btn btn-danger">Tolak</button>
                                                                <button id="approveBtn" type="button" class="btn btn-success">Setujui</button>
                                                            </div>
                                                        </form>
                                                        <script>
                                                            document.getElementById('rejectBtn').addEventListener('click', function() {
                                                                document.getElementById('loanForm').action = "{{ route('loans.tolak', ['id' => $loan->id]) }}";
                                                                document.getElementById('loanForm').submit();
                                                            });
                                                        
                                                            document.getElementById('approveBtn').addEventListener('click', function() {
                                                                document.getElementById('loanForm').action = "{{ route('loans.setujui', ['id' => $loan->id]) }}";
                                                                document.getElementById('loanForm').submit();
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
