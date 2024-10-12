@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Konfirmasi Pembayaran</h5>
                <div class="card-body">
                    <div class="border p-3 mb-3 rounded">
                        <h6>ID Pembayaran: <strong>{{ $orderId }}</strong></h6>
                        <div class="mb-2">
                            <strong>Detail Pembayaran:</strong>
                            <ul class="list-unstyled">
                                @foreach ($itemDetails as $item)
                                    <li class="d-flex justify-content-between">
                                        <span>{{ ucwords($item['name']) }}</span> 
                                        <span>Rp{{ number_format($item['price'], 2, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <strong>Total Pembayaran:</strong> 
                            <span>Rp{{ number_format(collect($itemDetails)->sum('price'), 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('create.payment.session') }}" method="POST" id="payment-form" class="text-end">
                        @csrf
                        <input type="hidden" name="snapToken" value="{{ $snapToken }}">
                        <input type="hidden" name="orderId" value="{{ $orderId }}">
                        <input type="hidden" name="itemDetails" value="{{ json_encode($itemDetails) }}">
                    
                        <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.server_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    var paymentForm = document.getElementById('payment-form');

    payButton.addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah form langsung di-submit

        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('payments.index') }}";
            },
            onPending: function (result) {
                paymentForm.submit();
            },
            onError: function (result) {
                console.log('Payment error:', result);
            },
            onClose: function () {
                console.log('Payment popup closed without finishing the payment.');
            }
        });
    });
</script>

@endsection
