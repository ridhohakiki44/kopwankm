@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Bayar Simpanan</h1>
    <p>Jumlah: {{ $simpanan->jumlah }}</p>
    <button id="pay-button" class="btn btn-primary">Bayar</button>

    <form action="{{ route('savings.index') }}" method="GET" id="redirect-form" style="display: none;">
        @csrf
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                document.getElementById('redirect-form').submit();
            },
            onPending: function(result) {
                document.getElementById('redirect-form').submit();
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>
@endsection
