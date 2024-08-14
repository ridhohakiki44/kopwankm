@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Angsuran Pinjaman</h5>
                <div class="card-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jumlah Angsuran</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Tanggal Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installments as $installment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Rp{{ number_format($installment->jumlah, 2, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($installment->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $installment->status }}</td>
                                        <td>
                                            @if ($installment->status == 'dibayar')
                                                {{ \Carbon\Carbon::parse($installment->updated_at)->translatedFormat('d F Y H:i') }}
                                            @endif
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

@endsection
