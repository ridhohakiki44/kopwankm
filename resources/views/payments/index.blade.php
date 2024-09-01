@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Pembayaran</h5>
                <div class="card-body">
                    <form action="{{ route('payments.process') }}" method="POST">
                        @csrf

                        <h6>Pilih Simpanan yang Akan Dibayar:</h6>
                        @if ($savings->isEmpty())
                            <p>Tidak ada simpanan yang belum dibayar.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Jenis Simpanan</th>
                                        <th>Jumlah</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($savings as $saving)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="savings[]" value="{{ $saving->id }}">
                                            </td>
                                            <td>Simpanan {{ ucfirst($saving->jenis_simpanan) }}</td>
                                            <td>Rp{{ number_format($saving->jumlah, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($saving->denda != null)
                                                    Rp{{ number_format($saving->denda, 2, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <h6 class="mt-4">Pilih Angsuran yang Akan Dibayar:</h6>
                        @if ($installments->isEmpty())
                            <p>Angsuran bulan ini sudah dibayar.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Jumlah</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($installments as $installment)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="installments[]" value="{{ $installment->id }}">
                                            </td>
                                            <td>Rp{{ number_format($installment->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($installment->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                                            <td>
                                                @if ($installment->denda != null)
                                                    Rp{{ number_format($installment->denda, 2, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
