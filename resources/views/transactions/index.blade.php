@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h5 class="mb-3 mb-md-0">Laporan</h5>

                    @if ($transactions->isEmpty())
                        @if (auth()->user()->role == 'sekretaris')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#setBalanceModal">
                                Set Balance
                            </button>
                        @endif
                    @else
                        <div class="d-flex flex-column flex-md-row">
                            <div class="button-wrapper">
                                <button type="button" class="btn btn-label-success me-2" data-bs-toggle="modal" data-bs-target="#printModal">
                                    <i class="ti ti-printer d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cetak Laporan</span>
                                </button>
    
                                @if (auth()->user()->role == 'sekretaris')
                                    <a href="{{ route('transactions.create') }}" class="btn btn-success">
                                        <i class="ti ti-plus d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Tambah Laporan</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">

                    @if ($transactions->isEmpty())
                        <p>Tidak ada laporan</p>
                    @else
                        <div class="table-responsive">
                            <table class="table" style="width: 1170px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>
                                                @if ($transaction->debit)
                                                    Rp{{ number_format($transaction->debit, 2, ',', '.') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($transaction->credit)
                                                    Rp{{ number_format($transaction->credit, 2, ',', '.') }}
                                                @endif
                                            </td>
                                            <td>Rp{{ number_format($transaction->balance, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Set Balance Modal -->
<div class="modal fade" id="setBalanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form action="{{ route('transactions.set-balance') }}" method="POST" id="formSetBalance">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambahkan saldo awal
                    </h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="description" class="form-label">Uraian</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="Masukan uraian" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="balance" class="form-label">Saldo</label>
                            <input type="text" id="balance" name="balance" class="form-control" placeholder="Masukan saldo" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal untuk Cetak Laporan -->
<div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transactions.print') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Cetak Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="date_range" class="form-label">Rentang Tanggal</label>
                            <input type="text" id="date_range" name="date_range" class="form-control" placeholder="Pilih rentang tanggal" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "d F Y",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                },
                months: {
                    shorthand: [
                        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                    ],
                    longhand: [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ],
                },
            }
        });
    });
</script>

@endsection
