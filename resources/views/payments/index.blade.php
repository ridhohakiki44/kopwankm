@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <h5 class="card-header">Pembayaran</h5>
                <div class="card-body">
                    <form action="{{ route('payments.process') }}" method="POST">
                        @csrf

                        <h6>Pilih Simpanan yang Akan Dibayar:</h6>
                        @if ($savings->isEmpty())
                            <p>Tidak ada simpanan yang belum dibayar.</p>
                        @else
                            <div class="table-responsive text-nowrap">
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
                            </div>
                        @endif

                        <h6 class="mt-4">Pilih Angsuran yang Akan Dibayar:</h6>
                        @if ($installments->isEmpty())
                            <p>Angsuran bulan ini sudah dibayar.</p>
                        @else
                            <div class="table-responsive text-nowrap">
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
                            </div>
                        @endif

                        @if (!$savings->isEmpty() || !$installments->isEmpty())
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Pembayaran Pending</h5>
                <div class="card-body">
                    @if ($pendingPayments->isEmpty())
                        <p>Tidak ada pembayaran yang pending.</p>
                    @else
                        @foreach ($pendingPayments as $payment)
                            <div class="border p-3 mb-3 rounded">
                                <h6>ID Pembayaran: <strong>{{ $payment->order_id }}</strong></h6>
                                <div class="mb-2">
                                    <strong>Detail Pembayaran:</strong>
                                    <ul class="list-unstyled">
                                        @foreach ($payment->item_details as $item)
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ucwords($item['name']) }}</span> 
                                                <span>Rp{{ number_format($item['price'], 2, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <strong>Total Pembayaran:</strong> 
                                    <span>Rp{{ number_format(collect($payment->item_details)->sum('price'), 2, ',', '.') }}</span>
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <strong>Status:</strong> 
                                    <span>{{ ucfirst($payment->status) }}</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success continue-pay-button" data-snap-token="{{ $payment->snap_token }}">Lanjutkan Pembayaran</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.server_key') }}"></script>
<script type="text/javascript">
    document.querySelectorAll('.continue-pay-button').forEach(function(button) {
        button.addEventListener('click', function () {
            var snapToken = this.getAttribute('data-snap-token');
            snap.pay(snapToken, {
                onSuccess: function (result) {
                    window.location.href = "{{ route('payments.index') }}";
                },
                onPending: function (result) {
                    console.log('Payment pending:', result);
                },
                onError: function (result) {
                    console.log('Payment error:', result);
                },
                onClose: function () {
                    console.log('Payment popup closed without finishing the payment.');
                }
            });
        });
    });
</script>

@endsection
