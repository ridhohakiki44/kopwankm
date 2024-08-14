@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Konfirmasi Pembayaran</h5>
                <div class="card-body">
                    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.server_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                console.log('Payment success:', result);
                // Redirect atau lakukan aksi setelah pembayaran sukses
                window.location.href = "{{ route('payments.index') }}";
            },
            onPending: function (result) {
                console.log('Payment pending:', result);
                // Redirect atau lakukan aksi jika pembayaran pending
            },
            onError: function (result) {
                console.log('Payment error:', result);
                // Redirect atau lakukan aksi jika pembayaran gagal
            },
            onClose: function () {
                console.log('Payment popup closed without finishing the payment.');
                // Lakukan sesuatu jika popup pembayaran ditutup tanpa penyelesaian
                window.location.href = "{{ route('payments.index') }}";
            }
        });
    });
</script>

@endsection
