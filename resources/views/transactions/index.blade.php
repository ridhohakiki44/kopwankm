@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Riwayat Transaksi
                    @if ($transactions->isEmpty())
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Set Balance
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
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
                    @else
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                    @endif
                </h5>
                <div class="card-body">

                    @if ($transactions->isEmpty())
                        <p>Tidak ada riwayat transaksi</p>
                    @else
                        <table class="table">
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
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->credit)
                                                Rp{{ number_format($transaction->credit, 2, ',', '.') }}
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>Rp{{ number_format($transaction->balance, 2, ',', '.') }}</td>
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

@endsection
