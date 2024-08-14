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
                            @foreach ($savings as $saving)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="savings[]" value="{{ $saving->id }}">
                                    <label class="form-check-label">
                                       Simpanan {{ $saving->jenis_simpanan }} - Rp{{ number_format($saving->jumlah, 2, ',', '.') }}
                                    </label>
                                </div>
                            @endforeach
                        @endif

                        <h6 class="mt-4">Pilih Angsuran yang Akan Dibayar:</h6>
                        @if ($installments->isEmpty())
                            <p>Angsuran bulan ini sudah dibayar.</p>
                        @else
                            @foreach ($installments as $installment)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="installments[]" value="{{ $installment->id }}">
                                    <label class="form-check-label">
                                        Pinjaman ID {{ $installment->loan_id }} - Rp{{ number_format($installment->jumlah, 2, ',', '.') }} - Jatuh Tempo: {{ \Carbon\Carbon::parse($installment->jatuh_tempo)->translatedFormat('d F Y') }}
                                    </label>
                                </div>
                            @endforeach
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
