@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Angsuran Pinjaman</h5>
                <div class="card-body">

                    <!-- Input Pencarian -->
                    @if (auth()->user()->role != 'anggota')
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="searchName" class="form-control" placeholder="Cari Nama">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="searchStatus" class="form-control" placeholder="Cari Status">
                            </div>
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if (auth()->user()->role != 'anggota')
                                    <td>Nama Anggota</td>
                                @endif
                                <th>Jumlah Angsuran</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Tanggal Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody id="installmentTableBody">
                            @foreach ($installments as $installment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if (auth()->user()->role != 'anggota')
                                        <td>{{ $installment->loan->user->name }}</td>
                                    @endif
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInputs = {
            name: document.getElementById('searchName'),
            status: document.getElementById('searchStatus')
        };

        const installmentTableBody = document.getElementById('installmentTableBody');
        const installments = installmentTableBody.getElementsByTagName('tr');

        Object.values(searchInputs).forEach(input => {
            input && input.addEventListener('input', function () {
                filterTable();
            });
        });

        function filterTable() {
            for (let i = 0; i < installments.length; i++) {
                const installmentRow = installments[i];
                let show = true;

                if (searchInputs.name && searchInputs.name.value && !installmentRow.children[1].textContent.toLowerCase().includes(searchInputs.name.value.toLowerCase())) {
                    show = false;
                }
                if (searchInputs.status && searchInputs.status.value && !installmentRow.children[4].textContent.toLowerCase().includes(searchInputs.status.value.toLowerCase())) {
                    show = false;
                }

                installmentRow.style.display = show ? '' : 'none';
            }
        }
    });
</script>

@endsection
