@extends('layouts.main')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Pinjaman</h5>
                    <div class="card-body">
                        @if ($loans->isEmpty() || $loans->every(fn($loan) => $loan->status === 'lunas'))
                            @if (auth()->user()->role == 'anggota')
                                <a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">Ajukan Pinjaman</a>
                            @endif
                        @endif
                        
                        <!-- Input Pencarian -->
                        @if (auth()->user()->role != 'anggota')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" id="searchName" class="form-control mb-2" placeholder="Cari Nama">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="searchStatus" class="form-control mb-2" placeholder="Cari Status">
                                </div>
                            </div>
                        @endif

                        <div class="card-datatable text-nowrap" id="both-scrollbars-example" style="height: 500px">
                            @if ($loans->isEmpty())
                                <p>Tidak ada pinjaman.</p>
                            @else
                                <table class="table">
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
                                                        data-bs-target="#modals-transparent">

                                                    <!-- Modal transparan -->
                                                    <div class="modal modal-transparent fade" id="modals-transparent"
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
                                                <td>{{ $loan->status }}</td>
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
