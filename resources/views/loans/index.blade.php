@extends('layouts.main')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <h5 class="mb-3 mb-md-0">Pinjaman</h5>

                        @if ($loans->isEmpty() || $loans->every(fn($loan) => $loan->status === 'lunas'))
                            @if (auth()->user()->role == 'anggota')
                                <a href="{{ route('loans.create') }}" class="btn btn-primary">Ajukan Pinjaman</a>
                            @endif
                        @endif
                    </div>


                    <div class="card-body">
                        
                        <!-- Input Pencarian -->
                        @if (auth()->user()->role != 'anggota')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchName" class="form-control" placeholder="Cari Nama">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchStatus" class="form-control" placeholder="Cari Status">
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            @if ($loans->isEmpty())
                                <p>Tidak ada pinjaman.</p>
                            @else
                                <table class="table" style="width: 1350px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            @if (auth()->user()->role != 'anggota')
                                                <th>Nama Anggota</th>
                                            @endif
                                            <th>Jumlah Pinjaman</th>
                                            <th>Jangka Waktu (bulan)</th>
                                            <th>Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Jaminan</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loanTableBody">
                                        @foreach ($loans as $loan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if (auth()->user()->role != 'anggota')
                                                    <td>{{ $loan->user->name }}</td>
                                                @endif
                                                <td>Rp{{ number_format($loan->jumlah, 2, ',', '.') }}</td>
                                                <td>{{ $loan->jangka_waktu }}</td>
                                                <td>{{ $loan->bank }}</td>
                                                <td>{{ $loan->no_rek }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $loan->jaminan) }}" alt="jaminan" width="50" data-bs-toggle="modal"
                                                        data-bs-target="#modals-transparent-{{ $loop->iteration }}">

                                                    <!-- Modal transparan -->
                                                    <div class="modal modal-transparent fade" id="modals-transparent-{{ $loop->iteration }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <img id="modalImage" src="{{ asset('storage/' . $loan->jaminan) }}" class="img-fluid">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($loan->status == 'mengajukan') bg-label-primary 
                                                        @elseif($loan->status == 'ditolak') bg-label-danger 
                                                        @elseif($loan->status == 'disetujui') bg-label-success 
                                                        @elseif($loan->status == 'belum lunas') bg-label-warning 
                                                        @elseif($loan->status == 'lunas') bg-label-success 
                                                        @endif">
                                                        {{ $loan->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $loan->keterangan }}</td>
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
                status: document.getElementById('searchStatus')
            };

            const loanTableBody = document.getElementById('loanTableBody');
            const loans = loanTableBody.getElementsByTagName('tr');

            Object.values(searchInputs).forEach(input => {
                input && input.addEventListener('input', function () {
                    filterTable();
                });
            });

            function filterTable() {
                for (let i = 0; i < loans.length; i++) {
                    const loanRow = loans[i];
                    let show = true;

                    if (searchInputs.name && searchInputs.name.value && !loanRow.children[1].textContent.toLowerCase().includes(searchInputs.name.value.toLowerCase())) {
                        show = false;
                    }
                    if (searchInputs.status && searchInputs.status.value && !loanRow.children[7].textContent.toLowerCase().includes(searchInputs.status.value.toLowerCase())) {
                        show = false;
                    }

                    loanRow.style.display = show ? '' : 'none';
                }
            }
        });

    </script>

@endsection
